/**
 * Created by Jing on 2015/4/10.
 */

var UserHomepage = UserHomepage || {};
UserHomepage.user = null;
UserHomepage.imgDatas = {};
UserHomepage.lastPage = 0;
UserHomepage.init = function() {
    Scroll.init(
        function(){}
        ,function(){
            UserHomepage.requestImgs(UserHomepage.lastPage + 1);
        }
    );

    var userId = Cache.get(Const.CACHE_VISIT_USER_ID);
    if(null == userId)
    {
        alert("wrong!");
        return;
    }

    Net.get('user', 'get', {userId:userId},
        function (data) {
            data = data[0];
            UserHomepage.user = data;

            var url = Common.getHeadUrl(data.id, data.pic_url);
            $('.user-headimg')[0].src = url;
            $('.user-headimg')[0].onclick = function(){
                UserHomepage.updateInfo();
            }

            $('.user-name')[0].innerHTML = String.format('<h4 class="user-name">{0} <span>{1}</span><em>{2}</em></h4>',data.nickname,data.adress,data.sex == 0?'男':'女');

            $('.user-ship')[0].innerHTML = data.intro;

            UserHomepage.requestImgs(0);
        });


}

UserHomepage.requestImgs = function(page){
    UserHomepage.lastPage = page;
    var params = {};
    params.type = null;
    params.search = null;
    params.userId = UserHomepage.user.id;
    params.page = page;

    Net.get('img','get_list',params,
        function(data){
            var imgs = data.imgs;
            var labels = data.labels;
            if(imgs.length > 0)
            {
                UserHomepage.lastPage = page;

                var list = $("#img_list");
                //list.append('<ul>');
                for(var i = 0; i < imgs.length; i++)
                {
                    var photo = imgs[i];

                    UserHomepage.imgDatas[photo.photo_id] = photo;

                    var li ='<li><div id="img_div_{2}" class="img-div"><a href="#" class="view-photo-link" style="background-image:url({0})" onclick="{1}"></a></div><div class="photo-info"><a href="#" id="praise_{2}" onclick="UserHomepage.onPraiseClick({2})" class="like">{3}</a><a href="#" onclick="{1}" class="view">{4}</a>	</div>';
                    li = String.format(li
                        ,Const.IMG_PHOTO_DIR + photo.photo_id + ".jpg"
                        ,"UserHomepage.onImgClick(" + photo.photo_id + ")"
                        ,photo.photo_id
                        ,photo.praise_amount
                        ,photo.comment_amount
                        ,"Scroll.refresh()"
                    )
                    list.append(li);

                    var praiseList = Cache.get(Const.CACHE_PRAISE_LIST);
                    if(praiseList.indexOf( photo.photo_id) > -1)
                    {
                        $("#praise_" + photo.photo_id).addClass('on');
                    }

                    for(var j = 0; j < labels.length; j++)
                    {
                        var label = data.labels[j];
                        if(label.photo_id == photo.photo_id)
                        {
                            var format = "<div id='tag' class='tag' style='left:"+label.anchor_x+"px;top:"+label.anchor_y+"px'>"+label.content+"</div>";
                            var imgDiv = $('#img_div_' + label.photo_id);
                            imgDiv.append(format);
                        }
                    }
                }
                //list.append('</ul>');
            }
            Scroll.refresh();
        });
}

UserHomepage.onImgClick = function(photoId){
    var photo =  UserHomepage.imgDatas[photoId];
    Cache.set(Const.CACHE_SELECTED_PHOTO_ID, photoId);
    if(Cache.get(Const.CACHE_OID) == photo.author_id)
    {
        //选中自己的图片
        Common.goPage("view_photo_myself.html");
    }
    else
    {
        //选中别人的图片
        Common.goPage("view_photo.html");
    }
}

UserHomepage.onPraiseClick = function(id){
    var photo =  UserHomepage.imgDatas[id];
    var link = $("#praise_" + id)[0];
    if(+link.innerHTML == +photo.praise_amount)
    {
        Net.get('img', 'praise', {photoId:id},
            function(data)
            {
                console.log("点赞结果：" + data);
                if(true == data)
                {
                    link.innerHTML = +photo.praise_amount + 1;
                    if(!$("#praise_" + id).hasClass('on')) {
                        $("#praise_" + id).addClass('on');
                    }
                }
            }
        )
    }
}

UserHomepage.updateInfo = function(){
    if(UserHomepage.user.id == Cache.get(Const.CACHE_OID))
    {
        //是自己，进入更新资料页面
        Common.goPage("user_settings.php");
    }
}
