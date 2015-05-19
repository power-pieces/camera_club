//---------------------------------------------------配置
var Const = Const || {};
Const.SERVER = 'http://localhost/camera_club/';
//Const.SERVER = 'http://photo.hb.vnet.cn/';
//Const.SERVER = 'http://www.g6game.com/h5game/cameraclub/';
//Const.SERVER = 'http://192.168.0.110/camera_club/';
Const.IMG_AV_DIR = Const.SERVER + 'images/activities/';
Const.IMG_HEAD_DIR = Const.SERVER + 'images/head/';
Const.IMG_PHOTO_DIR = Const.SERVER + 'images/photo/';
Const.API = Const.SERVER  + 'server/interface.php';

//用户的ID
Const.CACHE_OID = 'oid';
//用户的数据
Const.CACHE_USER = 'user';
//选中的图片数据
Const.CACHE_SELECTED_PHOTO_ID = "selected_photo_id";
//拜访的用户ID
Const.CACHE_VISIT_USER_ID = "visit_user_id";
//活动列表
Const.CACHE_TYPE_LIST = "type_list";
//列表获取参数
Const.CACHE_IMG_LIST_PARAMS = "imgListParams";
//缓存的微信配置
Const.CACHE_WX_CONFIG = "wx_config";
//缓存的平台数据
Const.CACHE_OPEN_INFO = "open_info";
//微信调用凭证
Const.CACHE_WX_ATOKEN = 'wx_access_token';
//缓存要上传的图片信息
Const.CACHE_ADD_PHOTO_INFO = 'cache_add_photo_info';
//赞过的图片ID列表
Const.CACHE_PRAISE_LIST = 'praise_list';
//最后访问过的网页
Const.CACHE_LAST_VISIT = 'last_visit';
//选择的类型
Const.CACHE_TYPE_SELECTED = 'type_selected';



//--------------------------------------------------TODO 通用工具
var Common = Common || {};
/**
 * 获取头像
 * @param userId 用户ID
 * @param pic_url 用户的图片地址
 */
Common.getHeadUrl = function(userId, pic_url){
    var url = pic_url;
    if(url.indexOf("http://") == -1)
    {
        url = Const.IMG_HEAD_DIR + userId + ".jpg?v=" + Math.random();
    }
    return url;
}

/**
 * 回首页
 */
Common.goHome = function(){
    Cache.set(Const.CACHE_IMG_LIST_PARAMS, null);
    Common.goPage("index.php");
}

/**
 * 退回
 */
Common.goBack = function(){
    var url = Cache.get(Const.CACHE_LAST_VISIT);
    if("" == url)
    {
        return;
    }
    Common.goPage(url);
}

Common.goPage = function(url, lastVisit){
    if(null == lastVisit)
    {
        lastVisit = location.href;
    }
    Cache.set(Const.CACHE_LAST_VISIT, lastVisit);
    location.href = url;
}

Common.onError = function()
{
    alert("系统出现错误，将返回首页");
    Common.goHome();
}

Common.debug = function(data)
{
    if(true)
    {
        alert(JSON.stringify(data));
    }
}





//--------------------------------------------------TODO 字符串工具
var String = String || {};

String.format = function() {
    if (arguments.length == 0)
        return null;
    var str = arguments[0];
    for ( var i = 1; i < arguments.length; i++) {
        var re = new RegExp('\\{' + (i - 1) + '\\}', 'gm');
        str = str.replace(re, arguments[i]);
    }
    return str;
};

//--------------------------------------------------TODO 网络对象
var Net = Net || {};

Net.get = function(mod, action, params, callback){
    if(null == params)
    {
        params = {};
    }
    if(null == params.oid){
        params.oid = Cache.get(Const.CACHE_OID);
    }
    params = JSON.stringify(params);

    $.ajax({
        type: "get",
        url: Const.API,
        data: {mod:mod,action:action,params:params},
        async:false,
        cache:false,
        dataType: "text",
        success: function(response) {
            try
            {
                var jsonObj = JSON.parse(response);
            }
            catch(e)
            {
                document.body.innerHTML = response;
                Common.onError();
                return;
            }
            callback(jsonObj.data);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            var errInfo = "get {0}_{1} wrong:{2}; {3}; {4}";
            errInfo = String.format(errInfo,mod, action, JSON.stringify(XMLHttpRequest), textStatus, errorThrown);
            document.body.innerHTML = errInfo;
            Common.onError();
        }
    });
}

Net.post = function(mod,action,params,callback){
    if(params && null == params.oid){
        params.oid = Cache.get(Const.CACHE_OID);
    }
    params = JSON.stringify(params);

    $.ajax({
        type: "post",
        url: Const.API,
        data: {mod:mod,action:action,params:params},
        async:false,
        cache:false,
        dataType: "text",
        success: function(response) {
            try
            {
                var jsonObj = JSON.parse(response);
                if(jsonObj.error > 0)
                {
                    document.body.innerHTML = '<textarea style="width:100%; height:1080px">' + response + '</textarea>';
                    Common.onError();
                    return;
                }
            }
            catch(e)
            {
                document.body.innerHTML = response;
                Common.onError();
                return;
            }
            callback(jsonObj.data);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            var errInfo = "post wrong:{0}; {1}; {2}";
            errInfo = String.format(errInfo, JSON.stringify(XMLHttpRequest), textStatus, errorThrown);
            document.body.innerHTML = errInfo;
            Common.onError();
        }
    });

    //$.post(Const.API, {mod:mod,action:action,params:params}, function(response){
    //    try
    //    {
    //        var jsonObj = JSON.parse(response);
    //    }
    //    catch(e)
    //    {
    //        $(document.body).append(response);
    //        return;
    //    }
    //    callback(jsonObj.data);
    //})
}


//--------------------------------------------------TODO COOKIE操作
var Cache = Cache || {};
Cache.init = false;
Cache.data = {};

Cache._init = function(){
    //alert("初始化缓存");
    Cache.init = true;
    var tempData = null;
    try
    {
        var json = Cache._getCookie();
        json = unescape(json);
        //alert(json);
        tempData = JSON.parse(json);
    }
    catch(e)
    {
        alert(e);
        tempData = null;
    }

    if(tempData)
    {
        Cache.data = tempData;
    }
}

Cache._setCookie = function(content){
    document.cookie ="cache=" + content;
}

Cache._getCookie = function(){
    var cookieStr = document.cookie;
    var arr = cookieStr.split(";");
    for(var i = 0; i < arr.length; i++)
    {
        var temp = arr[i];
        var startIndex = temp.indexOf("cache=");
        if(startIndex > -1) {
            temp = temp.substring(startIndex + 6, temp.length);
            return temp;
        }
    }
    return null;
}


Cache.set = function(key, value){
    //alert("是否初始化缓存：" + Cache.init);
    if(false == Cache.init)
    {
        Cache._init();
    }

    try {
        Cache.data[key] = value;

        //alert(String.format("设置缓存数据:{0} => {1} : {2}",key,value, Cache.data[key]));
        //立刻存储数据
        var json = JSON.stringify(Cache.data);
        json = escape(json);
        Cache._setCookie(json);
    }
    catch(e)
    {
        alert("缓存出错:" + e);
    }
}

Cache.get = function(key){
    if(false == Cache.init)
    {
        Cache._init();
    }
    var data = Cache.data[key];
    if(null == data)
    {
        //alert("获取的缓存数据" + key + "不存在");
    }
    return data;
}

//--------------------------------------------------TODO 图像处理工具
var ImgTool = ImgTool || {};
//获取图片的数据
ImgTool.getData = function(img) {
    var cc2 = document.createElement("canvas");
    cc2.setAttribute("width", img.width);
    cc2.setAttribute("height", img.height);
    var ctx = cc2.getContext("2d");
    alert("获取图片数据1");
    ctx.drawImage(img, 0, 0, img.width, img.height);
    alert("获取图片数据2");
    var imgdata = cc2.toDataURL("image/jpeg");
    alert("获取图片数据3");
    //这里要截取掉前面多余的字符，来过滤出正确的base64图片编码
    imgdata = imgdata.substring(23);
    return imgdata;
}

//--------------------------------------------------TODO 屏幕滚动
var Scroll = Scroll || {};
Scroll.myScroll = null;
Scroll.refresh = function(){
    if(Scroll.myScroll != null) {
        Scroll.myScroll.refresh();
    }
}
Scroll.useScroll = function(){
    var myScroll = new IScroll("#wrapper", {
        scrollbars: true,
        mouseWheel: true,
        interactiveScrollbars: true,
        shrinkScrollbars: "scale",
        fadeScrollbars: true,
        useTransition: false,
        click:true
    });
    Scroll.myScroll = myScroll;
    document.addEventListener("touchmove", function (e) { e.preventDefault(); }, false);
}

Scroll.init = function(onTop, onBottom){
    var myScroll;
    var pullDownEl, pullDownL;
    var pullUpEl, pullUpL;
    var Downcount = 0, Upcount = 0;
    var loadingStep = 0;//加载状态0默认，1显示加载状态，2执行加载数据，只有当为0时才能再次加载，这是防止过快拉动刷新
    function pullDownAction() {//下拉事件
        setTimeout(function () {
            var el, li, i;
            el = $('#add');
            for (i = 0; i < 3; i++) {
                li = $("<li></li>");
                Downcount++;
                li.text('new Add ' + Downcount + " ！");
                el.prepend(li);
            }
            pullDownEl.removeClass('loading');
            pullDownL.html('下拉显示更多...');
            pullDownEl['class'] = pullDownEl.attr('class');
            pullDownEl.attr('class', '').hide();
            myScroll.refresh();
            loadingStep = 0;
        }, 200); //1秒
    }
    function pullUpAction() {//上拉事件
        setTimeout(function () {
            var el, li, i;
            el = $('#add');
            for (i = 0; i < 3; i++) {
                li = $("<li></li>");
                Upcount++;
                li.text('new Add ' + Upcount + " ！");
                el.append(li);
            }
            pullUpEl.removeClass('loading');
            pullUpL.html('上拉显示更多...');
            pullUpEl['class'] = pullUpEl.attr('class');
            pullUpEl.attr('class', '').hide();
            myScroll.refresh();
            loadingStep = 0;
        }, 200);
    }

    function loaded() {
        pullDownEl = $('#pullDown');
        pullDownL = pullDownEl.find('.pullDownLabel');
        pullDownEl['class'] = pullDownEl.attr('class');
        pullDownEl.attr('class', '').hide();

        pullUpEl = $('#pullUp');
        pullUpL = pullUpEl.find('.pullUpLabel');
        pullUpEl['class'] = pullUpEl.attr('class');
        pullUpEl.attr('class', '').hide();

        myScroll = new IScroll('#wrapper', {
            probeType: 2,//probeType：1对性能没有影响。在滚动事件被触发时，滚动轴是不是忙着做它的东西。probeType：2总执行滚动，除了势头，反弹过程中的事件。这类似于原生的onscroll事件。probeType：3发出的滚动事件与到的像素精度。注意，滚动被迫requestAnimationFrame（即：useTransition：假）。
            scrollbars: true,//有滚动条
            mouseWheel: true,//允许滑轮滚动
            fadeScrollbars: true,//滚动时显示滚动条，默认影藏，并且是淡出淡入效果
            bounce: true,//边界反弹
            interactiveScrollbars: true,//滚动条可以拖动
            shrinkScrollbars: 'scale',// 当滚动边界之外的滚动条是由少量的收缩。'clip' or 'scale'.
            click: true,// 允许点击事件
            momentum: true// 允许有惯性滑动
        });
        Scroll.myScroll = myScroll;

        //滚动时
        myScroll.on('scroll', function () {
            if (loadingStep == 0 && !pullDownEl.attr('class').match('flip|loading') && !pullUpEl.attr('class').match('flip|loading')) {
                if (this.y > 5) {
                    //下拉刷新效果
                    pullDownEl.attr('class', pullUpEl['class'])
                    pullDownEl.show();
                    myScroll.refresh();
                    pullDownEl.addClass('flip');
                    pullDownL.html('准备刷新...');
                    loadingStep = 1;
                    if(onTop)
                    {
                        onTop();
                    }
                } else if (this.y < (this.maxScrollY - 5)) {
                    //上拉刷新效果
                    pullUpEl.attr('class', pullUpEl['class'])
                    pullUpEl.show();
                    myScroll.refresh();
                    pullUpEl.addClass('flip');
                    pullUpL.html('准备刷新...');
                    loadingStep = 1;
                    if(onBottom)
                    {
                        onBottom();
                    }
                }
            }
        });
        //滚动完毕
        myScroll.on('scrollEnd', function () {
            if (loadingStep == 1) {
                if (pullUpEl.attr('class').match('flip|loading')) {
                    pullUpEl.removeClass('flip').addClass('loading');
                    pullUpL.html('Loading...');
                    loadingStep = 2;
                    pullUpAction();
                } else if (pullDownEl.attr('class').match('flip|loading')) {
                    pullDownEl.removeClass('flip').addClass('loading');
                    pullDownL.html('Loading...');
                    loadingStep = 2;
                    pullDownAction();
                }
            }
        });


    }

    loaded();
    document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
}

//--------------------------------------------------TODO 微信接口
var Weixin = Weixin || {};

Weixin.isInit = false;

Weixin.hasConfig = function(){
    if(Cache.get(Const.CACHE_WX_CONFIG) != null){
        return true;
    }
    return false;
}

Weixin.cache = function(config){
    Cache.set(Const.CACHE_WX_CONFIG, config);
}

/**
 * 初始化
 */
Weixin.init = function(userId, signature,time){
    if(false == Weixin.isInit)
    {
        //alert(1);
        var config = Cache.get(Const.CACHE_WX_CONFIG);
        //alert(2);
        if(null == config)
        {
            //alert("微信接口配置不存在");
            return;
        }
        try{
            if(signature)
            {
                config.signature = signature;
            }
			if(time)
            {
                config.timestamp = time;
            }
            //alert("微信配置：" + JSON.stringify(config));
            wx.config(config);
            Weixin.setShare(userId);
            Weixin.isInit = true;
        }
        catch(e)
        {
            alert(e);
        }
    }

}

/**
 * 设置分享内容
 * @param shareid
 */
Weixin.setShare = function(shareid){
    if(false == Weixin.isInit)
    {
        //alert("微信没有初始化");
        return;
    }
    wx.onMenuShareTimeline({
        title: '摄影俱乐部', // 分享标题
        desc: '描述内容', // 分享描述
        link: Const.SERVER + 'clint/index.php?share='+shareid, // 分享链接
        imgUrl: Const.SERVER + 'share_icon.png', // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数

        }
    });

    wx.onMenuShareAppMessage({
        title: '摄影俱乐部', // 分享标题
        desc: '描述内容', // 分享描述
        link:  Const.SERVER + 'clint/index.php?share='+shareid, // 分享链接
        imgUrl: Const.SERVER + 'share_icon.png', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () {
            // 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
        }
    });
}

/**
 * 选择照片
 */
Weixin.selectImg = function(callback){
    if(false == Weixin.isInit)
    {
        //alert("微信没有初始化");
        return;
    }


    wx.chooseImage({
        success: function (res) {
            // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            var localIds = res.localIds;
            if(localIds.length > 0)
            {
                var localId = localIds[0];
                callback(localId);
            }
            else
            {
                callback(null);
            }
        }
    });
}

Weixin.uploadImg = function(localId, callback){
    if(false == Weixin.isInit)
    {
        //alert("微信没有初始化");
        return;
    }

    wx.uploadImage({
        localId: localId, // 需要上传的图片的本地ID，由chooseImage接口获得
        isShowProgressTips: 1, // 默认为1，显示进度提示
        success: function (res) {
            var mediaId = res.serverId; // 返回图片的服务器端ID
            callback(mediaId)
        }
    });
}


