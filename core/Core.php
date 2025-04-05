<?php
namespace core;

use core\Http\Request;
use core\Route\Router;

class Core
{
    public function run()
    {
        $this->route();
    }

    /**
     * 路由处理
     */
    public function route()
    {
        //路由已注册路由信息
        $routeInfo = Router::$info;
        //获取接口请求地址
        $url = strtolower($this->getRequestUrl());
        $actionName = '';
        $controllerPath = '';
        $controllerName = '';
        $isExit = 0;

        $beforeMiddlewareObj = '';
        $afterMiddlewareObj = '';

        foreach ($routeInfo as $v){
            if ($v['url'] == $url){
                //判断路由请求
                if ($v['method'] != 'any'){
                    if (strtolower($_SERVER['REQUEST_METHOD']) != $v['method']){
                        continue;
                    }
                }

                //前置路由中间件处理
                if (isset($v['before_middleware']) && !empty($v['before_middleware'])){
                    $beforeMiddlewareObj = $v['before_middleware'];
                    $beforeMiddlewareObj->handle(new Request());
                }

                //后置路由中间件处理
                if (isset($v['after_middleware']) && !empty($v['after_middleware'])){
                    $afterMiddlewareObj = $v['after_middleware'];
                }

                //判断是否路由闭包
                if ($v['is_closure'] == 1){
                    $v['controller']();
                    exit;
                }else{
                    $controllerInfo = explode("/", $v['controller']);
                    $actionName = array_pop($controllerInfo);
                    //获取控制器名
                    $controllerName = $controllerInfo[count($controllerInfo)-1];
                    $controllerPath = 'app\\controllers\\'.implode("\\", $controllerInfo) . 'Controller';
                }
                $isExit = 1;
            }
        }

        if (!$isExit){
            pd(404);
        }
        if (!class_exists($controllerPath)) {
            exit($controllerPath . '控制器不存在');
        }
        if (!method_exists($controllerPath, $actionName)) {
            exit($actionName . '方法不存在');
        }
        $dispatch = new $controllerPath($controllerName, $actionName);
        $dispatch->$actionName();

        //后置路由处理
        if (!empty($afterMiddlewareObj)){
            $afterMiddlewareObj->handle(new Request());
        }
    }

    /**
     * 获取接口请求地址
     * @return false|mixed|string
     */
    public function getRequestUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');
        return $position === false ? $url : substr($url, 0, $position);
    }

}