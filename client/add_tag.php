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
	<title>添加标签</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/web.css" />
</head>
<body onload="init()" class="no-bottom">
	<!--图片-->
	<div class="photo">
		<img id="img" draggable="false" />
		<div id="photoImg"></div>
		<!--添加标签内容-->
		<div class="add-tag-content">
			<input type="text" placeholder="添加标签内容" />
			<span class="sure-btn">确定</span>
		</div>
	</div>
	
	<!--提示-->
	<p class="add-tag-tip">点击图片任意位置可添加标签</p>
	
	<!--下一步-->
	<div class="step-btns">
		<a href="javascript:;" onclick="AddTag.upload2()" class="btn next-step">提交</a>
        <a href="#" onclick="Common.goHome()" class="cancel">取消</a>
	</div>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/drag.js"></script>
    <script type="text/javascript" src="js/iscroll.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/add_tag.js"></script>
	<script type="text/javascript">

        function init(){

            try{

                AddTag.signature = '<?php echo $signature ?>';
                AddTag.time = '<?php echo $GLOBALS["timestamp"];?>';
                var accessToken = '<?php echo $GLOBALS["atoken"];?>';
                Cache.set(Const.CACHE_WX_ATOKEN, accessToken);

                $(function(){
                    $("#photoImg").on("click",function(event){
                        var x=event.clientX;
                        var y=event.pageY;
                        if(y<45){y=45;}
                        $(this).next(".add-tag-content").show();
                        $(this).next(".add-tag-content").children("input").val("").focus();
                        var maxW=$(window).width();
                        var maxH=$(".photo").height();

                        $(".sure-btn").unbind();
                        $(".sure-btn").on("click",function(){
                            var val=$(this).prev("input").val();
                            if(val){
                                $(".add-tag-content").hide();
                                var tagHtml="<div id='tag' class='tag' style='left:"+x+"px;top:"+y+"px'>"+val+"</div>";
                                $(".photo").append(tagHtml);

                                var last=$(".tag").last();
                                var w=last.width()+20;
                                var h=last.height()+10;
                                if((w+x)>maxW){
                                    last.css("left",(maxW-w)+"px");
                                }
                                if((y+h)>maxH){
                                    last.css("top",(maxH-h)+"px");
                                }
                                last.drag();
                            };
                        });
                    });
                })

                AddTag.init();
            }
            catch(e)
            {
                alert(e);
            }
        }
		
	</script>
	
</body>
</html>