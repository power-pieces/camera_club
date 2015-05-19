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
	<title>添加照片</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/web.css" />
</head>
<body onload="init()" class="no-bottom">
	<div class="main" id="wrapper">
		<div class="scroller">
			<!--大图-->
			<div class="photo"><img id="img" onclick="AddPhoto.selectPhoto()" src="" /></div>
			<!--form表单填写图片信息-->
			<form>
				<dl class="add-photo-info">
					<dt>起个响亮的标题吧(最多不超过20个字符)</dt>
					<dd><input id="img_title" type="text" class="add-photo-tit" /></dd>
				</dl>
				<dl class="add-photo-info">
					<dt>添加照片描述</dt>
					<dd><textarea id="img_desc" class="add-photo-des"></textarea></dd>
				</dl>
				<dl class="add-photo-info">
					<dt>选择类别(选择活动类别即可投稿参加活动)</dt>
					<dd>
						<select id="img_type" class="add-photo-category">
						</select>
					</dd>
				</dl>
				<div class="form-btns">
					<a href="javascript:;" onclick="AddPhoto.addTag()" class="add-tag">添加标签</a>
					<a href="javascript:;" onclick="AddPhoto.upload2()" class="add-photo-submit">直接提交</a>
                    <a href="#" onclick="Common.goHome()" class="cancel">取消</a>
				</div>
			</form>
		</div>
	</div>
</body>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="js/zepto.min.js"></script>
	<script type="text/javascript" src="js/iscroll.js"></script> 
	<script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/add_photo.js"></script>
    <script>
        function init(){
            try {
                AddPhoto.signature = '<?php echo $signature ?>';
                AddPhoto.time = '<?php echo $GLOBALS["timestamp"];?>';
                var accessToken = '<?php echo $GLOBALS["atoken"];?>';
                //alert(accessToken);
                Cache.set(Const.CACHE_WX_ATOKEN, accessToken);
                //alert("设置了signature:" + AddPhoto.signature);
                AddPhoto.init();
            }
            catch(e)
            {
                document.body.innerHTML = e;
            }
        }
    </script>
</html>