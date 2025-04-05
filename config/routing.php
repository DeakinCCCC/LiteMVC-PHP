<?php
use core\Route\Router;

Router::any('/test',function(){echo "test";});
Router::any('/','Index/index');
Router::any('/index','Index/index');