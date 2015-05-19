<?php
/**
 * 服务器框架的主类
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/9
 * Time: 0:39
 */

//加这句是为了去掉一些高版本PHP提示要移除旧版本PHP函数的警告
error_reporting(E_ALL & ~E_DEPRECATED);

class Main{

    /**
     * 请求
     * @param $mod 模块
     * @param $action 方法
     * @param $params 参数JSON对象
     */
    public static function call(&$mod, &$action, &$params)
    {
        //依赖的PHP
        $dependentConfigs = array('define');
        $dependentUtils = array('sql_helper', 'json_util','img_util');

        foreach ($dependentConfigs as $v)
        {
            $dependentFile = 'configs/'.$v.'.php';
            include $dependentFile;
        }

        foreach ($dependentUtils as $v)
        {
            $dependentFile = 'utils/'.$v.'.php';
            include $dependentFile;
        }

        $res = array();
        $res['error'] = 0;

        if($mod == $action)
        {
            $res['error'] = 1;
            $res['msg'] = 'mod can not equal action';
        }

        $apiFile = 'apis/'.$mod.'.php';

        include $apiFile;
        $mod = ucfirst($mod);
        $modObj = new $mod();
        $modObj->$action($params, $res);
        return $res;
    }
}