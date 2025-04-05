<?php
namespace core\Http;

class Request
{
    /**
     * 获取post的请求的所有参数
     * @param $param
     * @return mixed
     */
    public function post($param)
    {
        return $this->filter(isset($_POST[$param]) && !empty($_POST[$param]) ? $_POST[$param] : '');
    }

    /**
     * 获取get的请求的所有参数
     * @param $param
     * @return mixed
     */
    public function get($param)
    {
        $paramRes = isset($_GET[$param]) ? $_GET[$param] : '';
        if (empty($paramRes)){
            $allParam = $this->getAllParam();
            if (isset($allParam[$param])){
                $paramRes = $allParam[$param];
            }
        }
        return $this->filter($paramRes);
    }

    /**
     * 支持多种请求
     * @param $param
     * @return mixed
     */
    public function request($param)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET')
        {
            return $this->get($param);
        }elseif ($method == 'POST') {
            return $this->post($param);
        }else{
            echo '不合法的请求';die;
        }
    }

    /**
     * 接受文件类型
     * @param $param
     * @return mixed
     */
    public function file($param)
    {
        return $_FILES[$param] ? $_FILES[$param] : '';
    }

    /**
     * 对所有请求的参数进行过滤
     * @param $param
     * @return mixed
     */
    public function filter($param)
    {
        //进行一系列的过滤
        return $param;
    }

    /**
     * 获取URL请求的所有参数
     * @return array
     */
    public function getAllParam(){
        $url = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        $paramArr = parse_url($url);
        if (!isset($paramArr['query'])){
            return ;
        }
        return $this->convertUrlQuery($paramArr['query']);
    }

    /**
     * 将URL转为数组
     * @param $query
     * @return array
     */
    public function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    /**
     * 获取访问当前服务的端口
     * @return false|mixed
     */
    public static function port()
    {
        return $_SERVER['SERVER_PORT'] ? $_SERVER['SERVER_PORT'] : false;
    }
}