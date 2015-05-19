/**
 * Created by Jing on 2015/4/10.
 */

var AddTag = AddTag || {};
AddTag.signature = null;
AddTag.time = null;
AddTag.isUpload = false;
AddTag.photoInfo = null;
AddTag.init = function(){

    Weixin.init(Cache.get(Const.CACHE_OID), AddTag.signature, AddTag.time);

    AddTag.photoInfo = Cache.get(Const.CACHE_ADD_PHOTO_INFO);
    $("#img")[0].src = AddTag.photoInfo.localId;
}

AddTag.upload2 = function(){
    if(AddTag.isUpload)
    {
        alert("正在上传照片");
        return;
    }

    AddTag.isUpload = true;

    var labels = [];
    var tags = $(".tag");
    for(var i = 0; i < tags.length; i++)
    {
        var label = {};
        var tag = $(tags[i]);
        var left = tag.css("left");
        label.anchor_x = +left.replace("px",'');
        var top = tag.css("top");
        label.anchor_y = +top.replace("px",'');
        label.content = tags[i].innerHTML;
        labels.push(label);
    }

    Weixin.uploadImg(AddTag.photoInfo.localId,
        function(mediaId){
            var params = AddTag.photoInfo;
            params.imgData = mediaId;
            params.labels = labels;
            params.at = Cache.get(Const.CACHE_WX_ATOKEN);
            //alert(JSON.stringify(params));

            Net.post('img','publish2',params,
                function(photoId){
                    alert("上传照片成功!");
                    AddTag.isUpload = false;
                    Cache.set(Const.CACHE_SELECTED_PHOTO_ID, photoId);
                    Common.goPage("view_photo_myself.html","");
                }
            );
        }
    );
}
