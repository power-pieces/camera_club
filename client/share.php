<?php

//首先申请公众号，获得appid等信息，并且在公众平台上设置js安全域名。
$GLOBALS["file"] = "C:/wamp4/www/token.txt";
$GLOBALS["appid"] = "";
$GLOBALS["appsecrect"] = "";
$GLOBALS["noncestr"] = "";
$GLOBALS["timestamp"] = time();

function getShareToken($appid,$appsecrect,$noncestr,$fileurl,$timestamp)
{
	$GLOBALS["appid"] = $appid;
	$GLOBALS["appsecrect"] = $appsecrect;
	$GLOBALS["noncestr"] = $noncestr;
	$GLOBALS["file"] = $fileurl;
	$GLOBALS["timestamp"] = $timestamp;
	
	if (!file_exists($GLOBALS["file"]))
	{
		saveCache($appid,$appsecrect);
	}else{
		$cache = file_get_contents($GLOBALS["file"]);
		$cache = unserialize($cache);
		$now = time();
		if ($now-$cache["time"] > 5400)
		{
			saveCache($appid,$appsecrect);
		}else{
			$GLOBALS["atoken"] = $cache["token"];
			$GLOBALS["aticket"] = $cache["ticket"];
		}
	}
}


function curPageURL()
{
	$pageURL = 'http';

	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
	{
		$pageURL .= "s";
	}
	$pageURL .= "://";

	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function getsignature()
{
	$url = curPageURL();
	$urls = explode("#",$url);
	$url = $urls[0];
    $ex = "jsapi_ticket=".$GLOBALS["aticket"]."&noncestr=".$GLOBALS["noncestr"]."&timestamp=".$GLOBALS["timestamp"]."&url=";
    if(!isset($_SESSION)){
        session_start();
    }
    $_SESSION['signature_ex'] = $ex;
	$str = $ex.$url;
	return sha1($str);
}

function getsignature_ex()
{
    $str = "jsapi_ticket=".$GLOBALS["aticket"]."&noncestr=".$GLOBALS["noncestr"]."&timestamp=".$GLOBALS["timestamp"]."&url=";
    return $str;
}




function saveCache($appid,$appsecrect)
{
	$gettime = time();
	$GLOBALS["atoken"] = getToken($appid,$appsecrect);
	$GLOBALS["aticket"] = getTicket($GLOBALS["atoken"]);
	if ($GLOBALS["aticket"] == -1)
	{
		$GLOBALS["atoken"] = getToken($appid,$appsecrect);
		$GLOBALS["aticket"] = getTicket($GLOBALS["atoken"]);
	}
	if ($GLOBALS["aticket"] == -1)
	{
		$GLOBALS["atoken"] = getToken($appid,$appsecrect);
		$GLOBALS["aticket"] = getTicket($GLOBALS["atoken"]);
	}
	$arr = array("token"=>$GLOBALS["atoken"], "ticket"=>$GLOBALS["aticket"], "time"=>$gettime);
	$ss = serialize($arr);
	$fp = fopen($GLOBALS["file"],"w");
	fputs($fp,$ss);
	fclose($fp);

	$logf = file_get_contents($GLOBALS["file"]."log");
	$logf .= "\n";
	$logf .= json_encode($arr);
	$fp = fopen($GLOBALS["file"]."log","w");
	fputs($fp,$logf);
	fclose($fp);
}

function request_by_other_get($remote_server){

	$ch = curl_init();
	$timeout = 5;
	curl_setopt ($ch, CURLOPT_URL, $remote_server);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	//$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $data;
}

function getToken($appid,$appsecrect)
{
	$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecrect;
	$ret = request_by_other_get($url);
	$ret = json_decode($ret,true);
	if (!isset($ret["access_token"]))
	{
		return -1;
	}
	return $ret["access_token"];

}

function getTicket($atoken)
{
	$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$atoken."&type=jsapi";
	$ret = request_by_other_get($url);
	$ret = json_decode($ret,true);
	if (!isset($ret["ticket"]))
	{
		return -1;
	}
	return  $ret["ticket"];

}

?>