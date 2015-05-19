/**
 * Created by Jing on 2015/4/9.
 */

var Index = Index || {};
Index.user = {};
Index.imgDatas = {};

Index.init = function () {
    //alert("请求登陆");
    Net.get('user', 'login', Index.user,
        function (data) {
            //alert("登陆成功");
            data = data[0];
            Index.user = data;


            var url = Common.getHeadUrl(data.id, data.pic_url);
            data.pic_url = url;
            Cache.set(Const.CACHE_USER, data);
            Cache.set(Const.CACHE_OID, data.id);


            $('#headimg')[0].src = url;

            Index.getPraiseList();
            Scroll.init(
                function () {
                }
                , function () {
                    var params = Cache.get(Const.CACHE_IMG_LIST_PARAMS);
                    params.page += 1;
                    Cache.set(Const.CACHE_IMG_LIST_PARAMS, params);
                    Index.getImgList();
                }
            );


            Index.getBanner();

        }
    );

    //搜索
    $('.icon-search').on('click', function () {
        $('#searchBg').toggle();
        $('#searchWrap').toggle();

        $("#searchBg").on("click",function(){
            $("#searchWrap").hide();
            $(this).hide();
        });
    });


    //搜索完成
    $('#searchBtn').on('click', function () {
        //搜索值
        var result = $(this).next('input').val();
        $('#searchBg').hide();
        $('#searchWrap').hide();

        var params = Cache.get(Const.CACHE_IMG_LIST_PARAMS);
        params.page = 0;
        params.type = null;
        params.search = result;
        params.userId = null;
        params.page = 0;
        Cache.set(Const.CACHE_IMG_LIST_PARAMS, params);
        Index.clearImgList();
        Index.getImgList();
    });
}

Index.getPraiseList = function () {
    Net.get("img", "get_praise_list", null, function (data) {
        var arr = [];
        for (var k in data) {
            arr.push(data[k].photo_id);
        }
        Cache.set(Const.CACHE_PRAISE_LIST, arr);
        Index.getImgList();
    });
}


Index.goHomePage = function () {
    Cache.set(Const.CACHE_VISIT_USER_ID, Index.user.id);
    Common.goPage('user_homepage.html');
}


Index.clearImgList = function () {
    var list = $("#img_list")[0];
    list.innerHTML = '';
}


Index.getBanner = function () {
    Net.get("img", "type_list", null, function (data) {
        var swipe = $(".swipe-wrap");
        Cache.set(Const.CACHE_TYPE_LIST, data);
        var item = null;
        var useItem = null;
        var useIndex = 0;
        for (var i = 0; i < data.length; i++) {
            item = data[i];
            if (+item.banner == 1) {
                if (null == useItem) {
                    useItem = [item, item, item];
                    useIndex = 1;
                }
                else {
                    useItem[useIndex] = item;
                    useIndex++;
                }

                if (useIndex == 3) {
                    break;
                }


            }
        }

        if (useItem != null) {
            for (var i = 0; i < useItem.length; i++) {
                var item = useItem[i];
                var imgSrc = Const.IMG_AV_DIR + item.id + "_l.jpg";
                var banner = '<li><a href="#" onclick="Index.selectType(' + item.id + ')"><img src="' + imgSrc + '" /></a></li>';
                swipe.append(banner);
            }
            Index.bannerArea();
        }


    });
}

Index.bannerArea = function () {
    var bullets = document.getElementById("Pagation").getElementsByTagName("em");
    var slider = new Swipe(document.getElementById("slider"), {
        speed: 400,
        auto: 3000,
        callback: function (e, pos) {
            var i = bullets.length;
            while (i--) {
                bullets[i].className = " ";
            }
            bullets[e].className = "on";
        }
    });
}


Index.selectType = function (type) {
    //alert("选中的类别：" + type);
    Cache.set(Const.CACHE_TYPE_SELECTED, type);
    Common.goPage("activity_detail.html");
}

Index.getImgList = function () {
    //return;
    var params = Cache.get(Const.CACHE_IMG_LIST_PARAMS);
    if (null == params) {
        params = {};
        params.type = null;
        params.search = null;
        params.userId = null;
        params.page = 0;
        Cache.set(Const.CACHE_IMG_LIST_PARAMS, params);
    }

    Net.get('img', 'get_list', params,
        function (data) {
            //Common.debug(data);
            var imgs = data.imgs;
            var labels = data.labels;
            //alert("获取到的图片列表长度：" + data.length);
            if (0 == imgs.length && params.page > 0) {
                params.page -= 1;
                Cache.set(Const.CACHE_IMG_LIST_PARAMS, params);
            }

            var oid = Cache.get('oid');
            var list = $("#img_list");
            //list.append('<ul>');
            for (var i = 0; i < imgs.length; i++) {
                var photo = imgs[i];

                Index.imgDatas[photo.photo_id] = photo;

                // li = '<a href="#" class="view-photo-link" style="background-image:url({0})" onclick="{1}"></a>';
                var li = '<li><div id="img_div_{2}" class="img-div"><a href="#" class="view-photo-link" style="background-image:url({0})" onclick="{1}"></a></div><div class="photo-info"><a href="#" id="praise_{2}" onclick="Index.onPraiseClick({2})" class="like">{3}</a><a href="#" onclick="{1}" class="view">{4}</a>	</div>';
                li = String.format(li
                    , Const.IMG_PHOTO_DIR + photo.photo_id + ".jpg"
                    , "Index.onImgClick(" + photo.photo_id + ")"
                    , photo.photo_id
                    , photo.praise_amount
                    , photo.comment_amount
                    , "Scroll.refresh()"
                )
                list.append(li);
                var praiseList = Cache.get(Const.CACHE_PRAISE_LIST);
                if (praiseList.indexOf(photo.photo_id) > -1) {
                    $("#praise_" + photo.photo_id).addClass('on');
                }


                for (var j = 0; j < labels.length; j++) {
                    var label = data.labels[j];
                    if (label.photo_id == photo.photo_id) {
                        var format = "<div id='tag' class='tag' style='left:" + label.anchor_x + "px;top:" + label.anchor_y + "px'>" + label.content + "</div>";
                        var imgDiv = $('#img_div_' + label.photo_id);
                        imgDiv.append(format);
                    }
                }
            }
            //list.append('</ul>');


        });
}

Index.onImgClick = function (id) {
    var photo = Index.imgDatas[id];
    Cache.set(Const.CACHE_SELECTED_PHOTO_ID, id);
    //alert("选中的图片ID：" + id);
    if (Cache.get(Const.CACHE_OID) == photo.author_id) {
        //选中自己的图片
        Common.goPage("view_photo_myself.html");
    }
    else {
        //选中别人的图片
        Common.goPage("view_photo.html");
    }
}

Index.onPraiseClick = function (id) {
    var photo = Index.imgDatas[id];
    var link = $("#praise_" + id)[0];
    if (+link.innerHTML == +photo.praise_amount) {
        Net.get('img', 'praise', {photoId: id},
            function (data) {
                console.log("点赞结果：" + data);
                if (true == data) {
                    link.innerHTML = +photo.praise_amount + 1;
                    if (!$("#praise_" + id).hasClass('on')) {
                        $("#praise_" + id).addClass('on');
                    }
                }
            }
        )
    }
}