<?php
use core\route\Route;

Route::any('/test',function(){echo "test";});
Route::any('/','Index/index');
Route::any('/index','Index/index');