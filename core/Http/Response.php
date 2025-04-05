<?php
namespace core\Http;

class Response
{
    /**
     * 响应 json 数据
     * @param $data
     */
    public static function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);die;
    }
}