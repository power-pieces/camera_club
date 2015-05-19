/**
 * Created by Jing on 2015/4/9.
 */

var ActivityDetail = ActivityDetail || {};
ActivityDetail.selectedItem = null;

ActivityDetail.init = function(){

    Scroll.init();
    ActivityDetail.getBanner();
}

ActivityDetail.getBanner = function() {
    var data = Cache.get(Const.CACHE_TYPE_LIST);
    var type = Cache.get(Const.CACHE_TYPE_SELECTED);
    var item = null;
    for(var i = 0; i < data.length; i++)
    {
        item = data[i];
        if(item.id == type)
        {
            ActivityDetail.selectedItem = item;
            break;
        }
    }

    var img = $('#img');
    img[0].src = Const.IMG_AV_DIR + item.id + ".jpg";
    img[0].onload = function(){
        Scroll.refresh();
    };

}

ActivityDetail.searchType = function(){
    var params = Cache.get(Const.CACHE_IMG_LIST_PARAMS);
    params.type = ActivityDetail.selectedItem.id;
    Cache.set(Const.CACHE_IMG_LIST_PARAMS, params);
    Common.goPage("index.php");
}

ActivityDetail.addPhoto = function(){

    Common.goPage("add_photo.php");
}
