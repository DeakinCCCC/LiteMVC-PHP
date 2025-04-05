<?php
namespace core\Route;

class Router
{
    //所有注册路由信息
    public static $info = [];

    private static $instance;

    //注册过中间件的路由
    private static $middleware = [];

    /**
     * get方式请求路由
     * @param $url
     * @param $controller
     * @return Router
     */
    public static function get($url , $controller)
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance = new self();
        }

        $method = 'get';
        self::handleRoute($url , $controller, $method);

        return self::$instance;
    }

    /**
     * post方式请求路由
     * @param $url
     * @param $controller
     * @return Router
     */
    public static function post($url , $controller)
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance = new self();
        }

        $method = 'post';
        self::handleRoute($url , $controller, $method);

        return self::$instance;
    }

    /**
     * 接受任何请求的路由
     * @param $url
     * @param $controller
     * @return Router
     */
    public static function any($url , $controller)  
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance = new self();
        }
        $method = 'any';
        self::handleRoute($url , $controller, $method);

        return self::$instance;
    }

    /**
     * 路由处理
     * @param $url
     * @param $controller
     * @param $method
     */
    private static function handleRoute($url , $controller, $method)
    {
        $arr = [];
        $arr['url'] = $url;
        $arr['controller'] = $controller;
        $arr['method'] = $method;
        if (is_object($controller)){
            $arr['is_closure'] = true;
        }else{
            $arr['is_closure'] = false;
        }
        self::$info[] = $arr;
        self::$middleware['url'] = $url;
    }

    /**
     * 路由分组
     * @param $url
     * @param $func
     * @return Router
     */
    public static function group($group, $func)
    {
        $oldKey = array_keys(self::$info);
        $func();
        foreach (self::$info as $k => $v){
            if (!in_array($k, $oldKey)){
                $v['group'] = $group;
                self::$info[$k] = $v;
            }
        }
        return self::$instance;
    }

    /**
     * 前置中间件
     * @param $class
     */
    public function beforeMiddleware($class)
    {
        $this->handleMiddleware($class, 'before_middleware');
    }

    /**
     * 后置中间件
     * @param $class
     */
    public function afterMiddleware($class)
    {
        $this->handleMiddleware($class, 'after_middleware');
     }

    /**
     * 中间件路由处理
     * @param $class
     * @param $behavior
     */
    private function handleMiddleware($class, $behavior)
    {
        $middlewareUrl = self::$middleware['url'];
        $group = '';
        foreach (self::$info as $k => $v){
            if ($v['url'] == $middlewareUrl){
                $group = isset($v['group']) ? $v['group'] : '';
                $v[$behavior] = $class;
                self::$info[$k] = $v;
            }
        }
        if ($group){
            foreach (self::$info as $k => $v){
                if (isset($v['group']) && $v['group'] == $group){
                    $v[$behavior] = $class;
                    self::$info[$k] = $v;
                }
            }
        }
        unset(self::$middleware['url']);
     }
}