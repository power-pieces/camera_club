<?php

include 'weixin.php';

if (!is_weixin())
{
    //调试的时候可注释掉
    //exit("请使用手机微信登录");
}
function is_weixin()
{
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
    {
        return true;

    }
    return false;
}
//开启session,用于保存用户的openid
session_start();
//此游戏需要用到分享者的ID
if (isset($_GET["share"]))
    $shareid = $_GET["share"];
else
    $shareid = 0;
//微信接受用户许可后的回调地址，可携带开发者自定义的参数
//此游戏只需要加上分享者的ID即可
$backurl = $site."?share=".$shareid;
//如果sessio失效，并且是第一次点击链接，则向微信发送网页授权许可请求
if(!isset($_SESSION["openid"]) && !isset($_GET['code'])){
    //die("发送网页授权许可请求");
    //发送网页授权许可请求
    header("Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".urlencode($backurl)."&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirect");
    exit;
}
//得到玩家许可后，系统自动重新进入此页面，并携带自定义参数和code值。
$code = "";
//如果session存在
if(isset($_SESSION["openid"])) {

    $p = new Player($backurl);
    $p->openid = $_SESSION["openid"];

    //把openid存到session里面
    $p->saveToSession();
    $openid = $_SESSION["openid"];
}else if (isset($_GET['code'])){
    //没有session,根据code获取用户的信息
    $code = $_GET['code'];
    if($code != "") {
        $p = new Player($backurl);
        $p->getInfoFrom($code, $appid, $appsecrect);
        $p->saveToSession();
        //在此处可以保存用户的昵称头像等信息到数据库，已获取的信息查看Player.php
        $openid = $p->openid;
    }
}else{
    exit("error");
}
//var_dump($p);
//die();
//到此步，已经拿到用户的openid了，可根据游戏需求，自定义其他逻辑

//获取分享的ticket
getShareToken($appid,$appsecrect,$noncestr,$file,time());


?>


<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>湖北手机摄影俱乐部</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/web.css" />
</head>
<body onload="init()">
	<!--头部-->
	<header id="header">
		<!--2015-4-13-->
		<a href="#" onclick="Index.goHomePage()" class="logo-link"><img id="headimg" class="user-headimg" /></a>
		<!--添加照片-->
		<a href="add_photo.php" class="add-photo btn">添加照片</a>
		<!--搜索入口-->
		<a href="javascript:;" class="icon-search"></a>
		<!--分类入口-->
		<a href="category.html" class="icon-category"></a>
	</header>
	<!--头部结束-->
	
	<!--搜索-->
	<div class="search-bg" id="searchBg"></div>
	<div class="search-wrap" id="searchWrap">
		<span class="search-btn" id="searchBtn"></span><input type="text" placeholder="请输入关键字"/>
	</div>
<!--内容区-->
<div class="main" id="wrapper">
    <div class="scroller">
        <!--广告区（注：图片名不要用带ad的命名,有些浏览器会行进过滤对这种命名的结构不显示）
        <div class="banner"></div>-->

        <div id="slider" class="swipe">
            <div id="swipe_list" class="swipe-wrap">
            </div>
            <span class="propagation" id="Pagation"><em class="on"></em><em></em><em></em></span>
        </div>

        <!--图文列表-->
        <div id="pullDown" class="ub ub-pc c-gra">
            <div class="pullDownIcon"></div>
            <div class="pullDownLabel">下拉刷新</div>
        </div>

        <div class="photo-list">
            <ul id="img_list">
            </ul>
        </div>

        <div id="pullUp" class="ub ub-pc c-gra">
            <div class="pullUpIcon"></div>
            <div class="pullUpLabel">上拉显示更多...</div>
        </div>
    </div>
</div>
<!--内容区结束-->
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="js/zepto.min.js"></script>
<script type="text/javascript" src="js/iscroll.js"></script>
<script  type="text/javascript" src="js/swipe.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript">

    function init(){
        try {
            if(null == Cache.get(Const.CACHE_OPEN_INFO)) {
                var user = Index.user;
                user.inviter = "<?php echo $shareid;?>";
                user.openId = "<?php echo $p->openid;?>";
                user.nickname = "<?php echo $p->username;?>";
                user.headimgurl = "<?php echo $p->avatar;?>";
                user.sex = "<?php echo $p->sex;?>";
                user.sex = +user.sex - 1;
                user.adress = "<?php echo $p->area;?>";

                if("" == user.openId || "-1" == user.sex)
                {
                    alert("获取微信信息错误!");
                    return;
                }


                Cache.set(Const.CACHE_OPEN_INFO, user);
            }
            else{
                Index.user = Cache.get(Const.CACHE_OPEN_INFO);
            }
            //alert("user" + JSON.stringify(user));


            var wxConfigObj = {
                debug: true,
                appId: '<?php echo $appid;?>',
                //在share.php里面有储值
                timestamp: '<?php echo $GLOBALS["timestamp"];?>',
                nonceStr: '<?php echo $GLOBALS["noncestr"];?>',
                signature: '<?php echo getsignature();?>',
                jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'chooseImage','uploadImage']
            };
            //alert("cache wxconfig " + JSON.stringify(wxConfigObj));
            Weixin.cache(wxConfigObj);

            //if(null ==  Cache.get(Const.CACHE_WX_ATOKEN))
            //{
                var accessToken = '<?php echo $GLOBALS["atoken"];?>';
                Cache.set(Const.CACHE_WX_ATOKEN, accessToken);
                //alert("设置accesss_token:" + accessToken);
            //}

            Index.init();
        }
        catch(e)
        {
            alert(e);
        }
    }



</script>

</html>