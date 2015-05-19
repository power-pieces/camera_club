/**
 * Created by Jing on 2015/4/10.
 */

var ViewPhoto = ViewPhoto || {};
ViewPhoto.data = null;
ViewPhoto.init = function(){

        Scroll.useScroll();

        var photoId = Cache.get(Const.CACHE_SELECTED_PHOTO_ID);
        //alert("图片ID：" + photoId);
        Net.get('img', 'details', {photoId: photoId},
            function (data) {
                //alert(JSON.stringify(data));
                ViewPhoto.data = data;
                var url = Common.getHeadUrl(data.author_id, data.pic_url);
                $('#headimg')[0].src = url;
                $('#headimg')[0].onclick = function () {
                    ViewPhoto.visit(data.author_id);
                }

                document.title = data.author_name + "的个人主页";

                $('.user-name')[0].innerHTML = data.author_name;
                $('.upload-date')[0].innerHTML = "上传日期：" + data.date;

                $('#photo')[0].src = Const.IMG_PHOTO_DIR + photoId + ".jpg";
                $('.like')[0].innerHTML = data.praise_amount;
                $('.like')[0].onclick = function () {
                    ViewPhoto.onPraiseClick(data.photo_id);
                }
                $('.view')[0].innerHTML = data.comment_amount;

                $('#title')[0].innerHTML = "标题：" + data.title;
                $('#desc')[0].innerHTML = data.desc;

                var visitorList = $("#visitor_list");
                for (var i = 0; i < data.visitor.length; i++) {
                    var visitor = data.visitor[i];
                    var format = '<li><a href="#" onclick="ViewPhoto.visit(\'{0}\')"><img src="{1}" /></a></li>';
                    format = String.format(format, visitor.visitor_id, Common.getHeadUrl(visitor.visitor_id, visitor.pic_url));
                    visitorList.append(format);
                }


                var commentList = $("#comment_list");
                for (var i = 0; i < data.comments.length; i++) {
                    var comment = data.comments[i];
                    var format = '<p class="comment-text"><strong onclick="ViewPhoto.visit(\'{0}\')">{1}</strong>：{2}</p>';
                    //var format = '<div class="comment-username" onclick="ViewPhoto.visit(\'{0}\')"><span>{1}</span></div><p class="comment-text">{2}</p>';
                    if("" == comment.reply) {
                        format = String.format(format, comment.sender_id, comment.nickname, comment.content);
                    }
                    else{
                        format += '<p class="comment-text"><strong style="padding-left: 2rem">{3}回复</strong>：{4}</p>';
                        //format += '<div class="comment-content"><div class="comment-username"><span>{3}回复</span></div><p class="comment-text">{4}</p></div>';
                        format = String.format(format, comment.sender_id, comment.nickname, comment.content, ViewPhoto.data.author_name, comment.reply);
                    }

                    commentList.append(format);
                }

                for(var i = 0; i < data.labels.length; i++)
                {
                    var label = data.labels[i];
                    var format = "<div id='tag' class='tag' style='left:"+label.anchor_x+"px;top:"+label.anchor_y+"px'>"+label.content+"</div>";
                    $(".photo").append(format);
                }
                Scroll.refresh();
            }
        );
}

/**
 * 拜访选中的用户
 * @param userId
 */
ViewPhoto.visit = function(userId){
    console.log("访问用户", userId);
    Cache.set(Const.CACHE_VISIT_USER_ID, userId);
    Common.goPage('user_homepage.html');
}

ViewPhoto.onPraiseClick = function(id){
    Net.get('img', 'praise', {photoId:id},
        function(data)
        {
            console.log("点赞结果：" + data);
            if(true == data)
            {
                var link = $('.like')[0];
                link.innerHTML = +ViewPhoto.data.praise_amount + 1;
            }
        }
    )
}

//点击了提交评论按钮
ViewPhoto.onSubmitClick = function(){
    var tf = $('#comment_content')[0];
    if("" == tf.value){
        alert("评论内容不能为空");
        return;
    }
    Net.get('img', 'comment', {photoId:ViewPhoto.data.photo_id, content:tf.value},
        function(data){
            if(data){
                location.reload(false);
            }
        }
    );
}


