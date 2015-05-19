/**
 * Created by Jing on 2015/4/10.
 */

var ViewPhotoMyself = ViewPhotoMyself || {};

ViewPhotoMyself.init = function(){
    Scroll.useScroll();

    var user = Cache.get(Const.CACHE_USER);

    var photoId = Cache.get(Const.CACHE_SELECTED_PHOTO_ID);

    //alert("图片ID：" + photoId);
    Net.get('img','details',{photoId:photoId},
        function(data){
            //alert(JSON.stringify(data));
            var url = Common.getHeadUrl(data.author_id, data.pic_url);
            $('#headimg')[0].src = url;
            $('#headimg')[0].onclick = function(){
                ViewPhotoMyself.visit(data.author_id);
            }

            $('.user-name')[0].innerHTML = data.author_name;
            $('.upload-date')[0].innerHTML = "上传日期：" + data.date;

            $('#photo')[0].src = Const.IMG_PHOTO_DIR + photoId + ".jpg";
            $('#photo')[0].onload = function()
            {
                Scroll.refresh();
            }
            $('.like')[0].innerHTML = data.praise_amount;
            $('.view')[0].innerHTML = data.visit_amount;

            $('#title')[0].innerHTML = "标题：" + data.title;
            $('#desc')[0].innerHTML = data.desc;

            var visitorList = $("#visitor_list");
            for(var i = 0; i < data.visitor.length; i++)
            {
                var visitor = data.visitor[i];
                var format = '<li><a href="#" onclick="ViewPhotoMyself.visit(\'{0}\')"><img src="{1}" /></a></li>';
                format = String.format(format, visitor.visitor_id, Common.getHeadUrl(visitor.visitor_id, visitor.pic_url));
                visitorList.append(format);
            }


            var commentList = $("#comment_list");
            for(var i = 0; i < data.comments.length; i++)
            {
                var comment = data.comments[i];
                var format = '<p class="comment-text"><strong onclick="ViewPhoto.visit(\'{0}\')">{1}</strong>：{2}</p>';
                //var format = '<div class="comment-content"><div class="comment-username" onclick="ViewPhotoMyself.visit(\'{0}\')"><span>{1}</span></div><p class="comment-text">{2}</p></div>';
                if("" == comment.reply) {
                    format += '<div class="reply-btn"><a href="javascript:;" onclick="ViewPhotoMyself.onReplyClick({3})" class="btn">回复</a></div>';
                    format += '<div id="comment_{3}" class="reply-form" style="display:none;"><textarea id="reply_content_{3}" placeholder="说点什么吧"></textarea><a href="#" onclick="ViewPhotoMyself.reply({3})" class="btn reply-publish">发布</a></div>';
                    format = String.format(format, comment.sender_id, comment.nickname, comment.content, comment.id);
                }
                else
                {
                    format += '<p class="comment-text"><strong style="padding-left: 2rem">回复{1}</strong>：{2}</p>';
                    //format += '<div class="comment-content"><div class="comment-username"><span>回复{1}</span></div><p class="comment-text">{3}</p></div>';
                    format = String.format(format, comment.sender_id, comment.nickname, comment.content, comment.reply);
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
ViewPhotoMyself.visit = function(userId){
    Cache.set(Const.CACHE_VISIT_USER_ID, userId);
    Common.goPage('user_homepage.html');
}

ViewPhotoMyself.onReplyClick = function(commentId){
    var commentReply = $('#comment_' + commentId);
    commentReply.toggle();
    Scroll.refresh();
}

/**
 * 回复评论内容
 * @param commentId 评论ID
 * @param content 内容
 */
ViewPhotoMyself.reply = function(commentId)
{
    var tf = $('#reply_content_' + commentId)[0];
    var content = tf.value;
    Net.get('img','comment_reply',{comment_id:commentId, content:content},
        function(data){
            Common.goPage("view_photo_myself.html");
        }
    );
}

