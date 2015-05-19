/**
 * Created by Jing on 2015/4/5.
 */

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