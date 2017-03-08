<?php
/**
 *
 * Api接口入口
 */
ini_set("display_errors","on");
error_reporting(7);


define('BIND_MODULE','Home');
define('BIND_CONTROLLER','Api');
//define('BIND_ACTION','push');
define('APP_DEBUG',True);
define('APP_PATH','./Web/');
//define('RUNTIME_PATH', '../');
require './ThinkPHP/ThinkPHP.php';