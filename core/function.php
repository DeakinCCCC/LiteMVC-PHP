<?php

/**
 * 接口公共返回方法
 * @param int $code
 * @param string $msg
 * @param array $data
 */
function reJson($code = 0, $msg = '', $data = [])
{
    header('Content-Type: application/json');
    echo json_encode([
        'code' => $code,
        'msg' => $msg,
        'data' => empty($data) ? '' : $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * print_r 打印数据并终止程序
 * @param $data
 */
function pd($data)
{
    print_r($data);die;
}

/**
 * var_dump 打印数据并终止程序
 * @param $data
 */
function vd($data)
{
    var_dump($data);die;
}

/**
 * 打印并换行
 * @param $data
 */
function eol($data){
    echo $data.PHP_EOL;
}

/**
 * 获取 mysql 配置信息
 * @return mixed
 */
function getMysqlConfig(){
    $config = require_once APP_PATH.'config/mysql.php';
    return $config['pool_list']['base'];
}