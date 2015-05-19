/**
 * Created by Jing on 2015/4/10.
 */

var UserSetting = UserSetting || {};
UserSetting.signature = null;
UserSetting.time = null;
UserSetting.localId = null;
UserSetting.isUpload = false;
UserSetting.headChange = false;
UserSetting.init = function(){

    Weixin.init(Cache.get(Const.CACHE_OID), UserSetting.signature, UserSetting.time);
    Scroll.useScroll();

    var user = Cache.get(Const.CACHE_USER);
    var headimg = $('#headimg')[0];
    headimg.onclick = function(){

        Weixin.selectImg(function(source){
            UserSetting.localId = source;
            headimg.src = source;
            UserSetting.headChange = true;
            UserSetting.uploadHead2();
        });
    }

    var tfName = $('#txt_name')[0];
    var tfArea = $('#txt_area')[0];
    var tfIntro = $('#txt_intro')[0];
    var tfPhone = $('#txt_phone')[0];

    var boy = $('#boy');
    var girl = $('#girl');

    headimg.src = Common.getHeadUrl(user.id, user.pic_url);
    tfName.value = user.nickname;
    tfArea.value = user.adress;
    tfIntro.value = user.intro;
    tfPhone.value = user.phone;

    if(0 == user.sex)
    {
        boy.addClass("selected");
        girl.removeClass('selected');
    }
    else
    {
        boy.removeClass("selected");
        girl.addClass('selected');
    }


}

UserSetting.uploadHead = function(){
    if(false == UserSetting.headChange)
    {
        return;
    }

    if(UserSetting.isUpload == true)
    {
        alert("正在上传照片");
        return;
    }
    UserSetting.isUpload = true;

    var img = $('#headimg')[0];
    var date = ImgTool.getData(img);
    Net.post('user', 'update_head', {params:date},
        function(data){
            UserSetting.isUpload = false;
            if(data == true)
            {
                var user = Cache.get(Const.CACHE_USER);
                user.pic_url = user.id;
                user.pic_url = Common.getHeadUrl(user.id, user.pic_url);
                var headimg = $('#headimg')[0];
                headimg.src = user.pic_url;
                Cache.set(Const.CACHE_USER, user);
            }
        }
    );
}

UserSetting.uploadHead2 = function(){
    if(false == UserSetting.headChange)
    {
        return;
    }

    if(UserSetting.isUpload == true)
    {
        alert("正在上传照片");
        return;
    }
    UserSetting.isUpload = true;

    Weixin.uploadImg(UserSetting.localId,
        function(mediaId){
            Net.post('user', 'update_head2', {mediaId:mediaId,at:Cache.get(Const.CACHE_WX_ATOKEN)},
                function(data){

                    UserSetting.isUpload = false;
                    if(data == true)
                    {
                        alert("头像更新成功！");
                        var user = Cache.get(Const.CACHE_USER);
                        if(user.pic_url != user.id) {
                            user.pic_url = user.id;
                            Cache.set(Const.CACHE_USER, user);
                        }
                        var headimg = $('#headimg')[0];
                        headimg.src = Common.getHeadUrl(user.id, user.pic_url) + "?v=" + Math.random();
                    }
                    else
                    {
                        alert("头像上传失败,请稍后重试！");
                    }

                }
            );
        }
    );
}

UserSetting.update = function(){
    var tfName = $('#txt_name')[0];
    var tfArea = $('#txt_area')[0];
    var tfIntro = $('#txt_intro')[0];
    var tfPhone = $('#txt_phone')[0];

    var boy = $('#boy');

    var params = {};
    params.nickname = tfName.value;
    params.sex = boy.hasClass("selected")?0:1;
    params.adress = tfArea.value;
    params.intro = tfIntro.value;
    params.phone = tfPhone.value;

    Net.get('user', 'update_info', params,
        function(data){
            if(data == true)
            {
                var user = Cache.get(Const.CACHE_USER);
                user.sex = params.sex;
                user.nickname = params.nickname;
                user.adress = params.adress;
                user.intro = params.intro;
                user.phone = params.phone;
                Cache.set(Const.CACHE_USER, user);

                Common.goPage("user_homepage.html");
            }
        });
}




