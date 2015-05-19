<?php
/**
 * 可通过上传图片、设定活动日期来创建新活动，活动指定链接在首页的广告栏图片，这个广告栏图片也是可以通过后台上传的。
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/13
 * Time: 10:22
 */

if(isset($_REQUEST['name']))
{
    date_default_timezone_set('Asia/Shanghai');
    $end = $_REQUEST['end'];
    $end = strtotime($end);

    include '../server/configs/define.php';
    include '../server/utils/sql_helper.php';

    $savepath='../images/activities/';
    var_dump($_REQUEST);
    var_dump($_FILES);


    $sql = "CALL add_activities('%s',%d);";
    $sql = sprintf($sql,
        mysql_escape_string($_REQUEST['name'])
        ,mysql_escape_string($end)
    );

    $st = new SqlHelper();
    $st->conn();
    $result = $st->query($sql);
    if($result)
    {
        $id = $result[0]['identity'];
        foreach($_FILES as $k => $file)
        {
            $name = $id;
            if($k == 'pi')
            {
                $name = $name."_l";
            }
            move_uploaded_file($file['tmp_name'], $savepath.$name.'.jpg');
        }

        header("Location:av_mng.php");
        exit;
    }
    else
    {
        $res['error'] = 1;
        $res['msg'] = 'sql wrong';
    }
    die(0);
}
?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <table border="0">
        <tr>
            <td>活动名称：</td>
            <td><input type="text" name="name" /></td>
        </tr>
        <tr>
            <td>活动预览图：</td>
            <td><input type="file" name="pi" /></td>
        </tr>
        <tr>
            <td>活动图：</td>
            <td><input type="file" name="img" /></td>
        </tr>
        <tr>
            <td>活动结束日期：</td>
            <td><input type="date" name="end" /></td>
        </tr>
    </table>
    <input type="submit" value="上传" />
</form>
</body>
</html>