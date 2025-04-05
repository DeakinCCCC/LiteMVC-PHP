<?php
namespace app\middleware;

use core\Middleware\Middleware;
use core\Http\Request;

class CheckUser implements Middleware
{
    public function handle(Request $request)
    {
        echo '我是后置中间件，在这儿可以进行业务处理'."<br/>";
    }
}