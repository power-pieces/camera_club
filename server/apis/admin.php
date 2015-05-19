<?php
/**
 * 管理模块
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/9
 * Time: 20:18
 */

class Admin
{
    /**
     * 增加活动
     * @param $params
     * @param $res
     */
    public function add_activities(&$params, &$res)
    {
        //$params->name;
        $nameCode = md5($params->name);

        $previewImgUrl = 'pre_'.$nameCode.'jpg';
        file_put_contents(DIR_AV.$previewImgUrl, $params->previewImgData);

        $imgUrl = $nameCode.'jpg';
        file_put_contents(DIR_AV.$imgUrl, $params->imgData);

        //$params->endUtc;
        $sql = "CALL add_activities('%s','%s','%s',%d);";
        $sql = sprintf($sql,
            mysql_escape_string($params->name)
            ,mysql_escape_string($previewImgUrl)
            ,mysql_escape_string($imgUrl)
            ,mysql_escape_string($params->endUtc)
        );

        $st = new SqlHelper();
        $st->conn();
        $result = $st->modify($sql);
        if($result)
        {
            $res['data'] = $result;
        }
        else
        {
            $res['error'] = 1;
            $res['msg'] = 'sql wrong';
        }
    }
}