<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/7
 * Time: 16:23
 */

include 'common.php';

if(isset($_REQUEST['banner']))
{
    $banner = $_REQUEST['banner'];
    $id = $_REQUEST['id'];
    $sql = "UPDATE tbl_activities SET banner=$banner WHERE id=$id";
    $sh = new SqlHelper();
    $sh->conn();
    //die($sql);
    $result = $sh->modify($sql);
    if($result)
    {
        //echo '<script>alert("修改成功!")</script>';
    }
    else
    {
        echo '<script>alert("修改失败!")</script>';
    }
}
else if(isset($_REQUEST['del']))
{
    $id = $_REQUEST['del'];
    $sql = "DELETE FROM tbl_activities WHERE id=$id";
    $sh = new SqlHelper();
    $sh->conn();
    //die($sql);
    $result = $sh->modify($sql);
    if($result)
    {
        //echo '<script>alert("修改成功!")</script>';
    }
    else
    {
        echo '<script>alert("删除失败!")</script>';
    }
}

?>

<!DOCTYPE html>
<html>

<script>
    function changeBanner(id)
    {
        var cb = document.getElementById(id);
        var banner = 0;
        if(cb.checked)
        {
            banner = 1;
        }
        location.href="av_mng.php?banner=" + banner + "&id=" + id;
    }
</script>

<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/g.css" />
    <title></title>
</head>
<body>

<table class="t">
    <td class="menu_td">
        <a href="admin.php">管理员账户</a><br/>
        <a href="user_mng.php">用户管理</a><br/>
        <a href="photo_mng.php">图片管理</a><br/>
        <a href="av_mng.php">类别管理</a><br/>
        <a href="data.php">数据统计</a><br/>
    </td>
    <td class="ctnt_td">
        <p class="title">类别管理</p>

<div>
    <table border="0" cellpadding="10px">
        <tr>
            <th>序号</th>
            <th>类别名称</th>
            <th>Banner图片</th>
            <th>活动页图片</th>
            <th>建立日期</th>
            <th>结束日期</th>
            <th>是否用于Banner</th>
            <th>操作</th>
        </tr>
        <?php

        $sh = new SqlHelper();
        $sh->conn();
        $list = array();
        $sql = 'SELECT * FROM tbl_activities';
        //die($sql);
        $result = $sh->query($sql);
        $index = 1;
        foreach($result as $v)
        {
            ?>
            <tr>
                <td><?php echo $v['id'] ?></td>
                <td><?php echo $v['name'] ?></td>
                <td><a href="../images/activities/<?php echo $v['id'] ?>_l.jpg"><img width="100" src="../images/activities/<?php echo $v['id'] ?>_l.jpg" /></a></td>
                <td><a href="../images/activities/<?php echo $v['id'] ?>.jpg"><img width="100" src="../images/activities/<?php echo $v['id'] ?>.jpg" /></a></td>
                <td><?php echo $v['date'] ?></td>
                <td><?php echo date('Y-m-d ',$v['end_utc']) ?></td>
                <td>
                    <input id="<?php echo $v['id'] ?>" type="checkbox" onclick="changeBanner(<?php echo $v['id'] ?>)" name="inBanner"  <?php echo $v['banner'] == '1'?'checked="true"':'' ?> />
                </td>
                <td>
                    <a href="av_edit.php?edit=<?php echo $v['id'] ?>">修改</a>
                    <a href="av_mng.php?del=<?php echo $v['id'] ?>">删除</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="activities.php">添加一个活动</a>
</div>

    </td>
</table>
</body>
</html>