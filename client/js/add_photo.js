/**
 * Created by Jing on 2015/4/10.
 */

var AddPhoto = AddPhoto || {};
AddPhoto.signature = null;
AddPhoto.time = null;
AddPhoto.localId = null;
AddPhoto.init = function(){


    Weixin.init(Cache.get(Const.CACHE_OID), AddPhoto.signature, AddPhoto.time);
    Scroll.useScroll();



    //alert(1);
    var types = $("#img_type")[0];
    //alert(2);
    var date = new Date();
    //alert(3);
    var now = parseInt(date.getTime() / 1000);
    //alert(4);
    var typeList = Cache.get(Const.CACHE_TYPE_LIST);
    //alert(5);
    //alert("数据" + typeList);
    for(var i = 0; i < typeList.length; i++)
    {
        //alert("添加数据");
        var item=typeList[i];
        if(now < +item.end_utc)
        {
            types.options.add(new Option(item.name, item.id));
        }
    }


}

AddPhoto.isUpload = false;

AddPhoto.upload = function(){
    if(AddPhoto.isUpload)
    {
        alert("正在上传照片");
        return;
    }
    try{
        AddPhoto.isUpload = true;
        //alert("开始上传照片");
        var params = {};
        params.oid = Cache.get(Const.CACHE_OID);
        //alert("开始上传照片_0");
        params.type = $("#img_type option:selected").val();
        //alert("开始上传照片_1");
        params.title = $("#img_title")[0].value;
      //  alert("开始上传照片_2");
        params.desc = $("#img_desc")[0].value;
    //    alert("开始上传照片_3");

        params.imgData = ImgTool.getData($("#img")[0]);
        alert("开始上传照片_4");
        params.labels = [];
        Net.post('img','publish',params,
            function(photoId){
                alert("上传照片成功!");
                AddPhoto.isUpload = false;
                Cache.set(Const.CACHE_SELECTED_PHOTO_ID, photoId);
                Common.goPage("view_photo_myself.html");
            }
        );
    }
    catch(e)
    {
        alert(e);
    }
}

AddPhoto.addTag = function(){
    var photoInfo = {};
    photoInfo.localId = AddPhoto.localId;
    photoInfo.oid = Cache.get(Const.CACHE_OID);
    photoInfo.type = $("#img_type option:selected").val();
    photoInfo.title = $("#img_title")[0].value;
    photoInfo.desc = $("#img_desc")[0].value;
    photoInfo.at = Cache.get(Const.CACHE_WX_ATOKEN);

    Cache.set(Const.CACHE_ADD_PHOTO_INFO, photoInfo);

    Common.goPage('add_tag.php');
}

AddPhoto.upload2 = function(){
    if(AddPhoto.isUpload)
    {
        alert("正在上传照片");
        return;
    }

    AddPhoto.isUpload = true;

    Weixin.uploadImg(AddPhoto.localId,
        function(mediaId){
            var params = {};
            params.oid = Cache.get(Const.CACHE_OID);
            params.type = $("#img_type option:selected").val();
            params.title = $("#img_title")[0].value;
            params.desc = $("#img_desc")[0].value;
            params.imgData = mediaId;
            params.at = Cache.get(Const.CACHE_WX_ATOKEN);
            params.labels = [];

            //alert(JSON.stringify(params));

            Net.post('img','publish2',params,
                function(photoId){
                    if(false == photoId)
                    {
                        alert("上传照片失败！");
                    }
                    else
                    {
                        alert("上传照片成功!");
                        AddPhoto.isUpload = false;
                        Cache.set(Const.CACHE_SELECTED_PHOTO_ID, photoId);
                        Common.goPage("view_photo_myself.html","");
                    }
                }
            );
        }
    );
}

AddPhoto.selectPhoto = function(){
    Weixin.selectImg(function(source){
        AddPhoto.localId = source;
        var img = $("#img")[0];
        img.src = source;
        img.onload=function(){
            Scroll.refresh();
        }
    });
}


