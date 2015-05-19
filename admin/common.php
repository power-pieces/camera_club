<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/7
 * Time: 11:17
 */
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');
include '../server/configs/define.php';
include '../server/utils/sql_helper.php';
session_start();

if(!isset($_SESSION['isLogin']))
{
    header("Location:login.php");
    exit;
}