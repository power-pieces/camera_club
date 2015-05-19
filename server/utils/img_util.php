<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/8
 * Time: 17:25
 */

class ImgUtil
{
    /**
     * 存储图片
     * @param $imgData 图片数据
     * @param $savePath 保存路径
     * @return 返回图片的地址
     */
    public static function saveImg(&$imgData, $dir, $fileName)
    {
        $savePath = $dir.$fileName.'.jpg';
        $image = base64_decode($imgData);
        file_put_contents($savePath,$image);
        return $savePath;
    }
}