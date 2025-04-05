<?php
//定义应用目录
const APP_PATH = __DIR__ . DIRECTORY_SEPARATOR;

//注册自动加载
require(APP_PATH . 'autoload.php');

//注册依赖组件自动加载
//require(APP_PATH . 'vendor/autoload.php');

//注册路由文件
require(APP_PATH . 'config/routing.php');

//加载公共函数文件
require(APP_PATH . 'core/function.php');

//实例化框架类并运行
(new core\Core())->run();