<?php
include 'weixin.php';
//获取分享的ticket
getShareToken($appid,$appsecrect,$noncestr,$file,time());

$signature = getsignature();
//exit;
?>

<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>账户设置</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/web.css" />
</head>
<body onload="init()" class="no-bottom">
	<div class="main" id="wrapper">
		<div class="scroller">
			<div class="settings-wrap">
				<!--账户设置标题-->
				<div class="settings-tit"><h2>账户设置</h2></div>
				<!--头像-->
				<div class="add-headimg">
					<h2>头像</h2>
					<img id="headimg" />
				</div>
				<!--用户信息表单-->
				<form>
					<dl class="settings-item">
						<dt>昵称</dt>
						<dd>
							<input id="txt_name" type="text" class="text-input" />
                            <!--<a href="javascript:;" class="btn">更改昵称</a><span class="del" id="nicknameDel"></span>-->
						</dd>
					</dl>
					<dl class="settings-item sex">
						<dt>性别</dt>
						<dd>
							<label id="boy"><em></em><span>男</span></label>
							<label id="girl"><em></em><span>女</span></label>
                            <!--<span class="del" id="sexDel"></span>-->
						</dd>
					</dl>
					<dl class="settings-item">
						<dt>地区</dt>
						<dd><input id="txt_area" type="text" class="text-input" /></dd>
					</dl>
					<dl class="settings-item">
						<dt>个性签名</dt>
						<dd><input id="txt_intro" type="text" class="text-input" /></dd>
					</dl>
					<dl class="settings-item">
						<dt>手机号码</dt>
						<dd><input id="txt_phone" type="tel" class="text-input" /></dd>
					</dl>

                    <div class="link-btns">
					    <a href="javascript:;" onclick="UserSetting.update()" class="btn save-btn">保存</a>
                        <a href="javascript:;" onclick="Common.goHome()" class="btn save-btn">返回</a>
                    </div>

				</form>
			</div>
		</div>
	</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="js/zepto.min.js"></script>
	<script type="text/javascript" src="js/iscroll.js"></script> 
	<script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/user_setting.js"></script>
	<script type="text/javascript">

        function init(){
            try {
                UserSetting.signature = '<?php echo $signature ?>';
                UserSetting.time = '<?php echo $GLOBALS["timestamp"];?>';
                var accessToken = '<?php echo $GLOBALS["atoken"];?>';
                Cache.set(Const.CACHE_WX_ATOKEN, accessToken);
                //alert("设置了signature:" + UserSetting.signature);
                UserSetting.init();

                $(function () {
                    //选择性别
                    $(".sex label").on("click", function () {
                        $(this).addClass("selected").siblings().removeClass("selected");
                    });

                    /*
                     //清空昵称
                     $("#nicknameDel").on("click",function(){
                     $(this).siblings(".text-input").val("");
                     });

                     //清空性别
                     $("#sexDel").on("click",function(){
                     $(".sex label").removeClass("selected");
                     });
                     */
                })
            }
            catch(e)
            {
                alert(e);
            }
        }
	</script>
</html>