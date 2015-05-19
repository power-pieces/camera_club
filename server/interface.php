<?php
//设置访问权限为所有域
header("Access-Control-Allow-Origin:*");
//设置默认时区
date_default_timezone_set("PRC");

include 'main.php';

//模块名称
$mod = $_REQUEST['mod'];
//动作名称
$action = $_REQUEST['action'];
//参数
$params = $_REQUEST['params'];

$jsonObj = json_decode($params);

$res = Main::call($mod,$action,$jsonObj);
echo JsonUtil::json_encode_cn($res);



