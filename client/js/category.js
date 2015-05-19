/**
 * Created by Jing on 2015/4/9.
 */

var Category = Category || {};
Category.scroll = null;

Category.init = function() {
    Scroll.init();

    Category.requestList();
}

Category.requestList = function() {
    Net.get("img","type_list",null, function(data)
    {
        Category.addType(-1, '全部');
        for(var i = 0; i < data.length; i++)
        {
            var item = data[i];
            Category.addType(item.id, item.name);
        }
    });
}

Category.addType = function(id, name){
    var itemStr='<li><a href="#" onclick="Category.selectType('+ id +')">'+name+'</a></li>';
    $("#type_list").append(itemStr);
}


Category.selectType = function(type){
    var params = Cache.get(Const.CACHE_IMG_LIST_PARAMS);
    params.page = 0;
    params.type = type == -1?null:type;
    params.search = null;
    params.userId = null;
    Cache.set(Const.CACHE_IMG_LIST_PARAMS, params);
    Common.goPage("index.php");
}