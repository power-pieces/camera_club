<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/28
 * Time: 20:31
 */

//首先申请公众号，获得appid等信息，并且在公众平台上设置js安全域名。
require_once 'share.php';
require_once 'Player.php';
$file = "../token.txt";
$appid = "wx34bbd2b8333f7e32";
$appsecrect = "bf1fcc56a20f7037fb450dada9e21717";
$noncestr = "dajiagame";
$site = "http://photo.hb.vnet.cn/client/index.php";



//首先申请公众号，获得appid等信息，并且在公众平台上设置js安全域名。
//require_once 'share.php';
//require_once 'Player.php';
//$file = "C:/wamp4/www/token.txt";
//$appid = "wx2c9e2b3c3e0cc058";
//$appsecrect = "cf67d528c6aab80cebbfcd0ac20c8aee";
//$noncestr = "dajiagame";