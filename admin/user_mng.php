<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/24
 * Time: 23:10
 */

include 'common.php';

?>


<!DOCTYPE html>
<html>
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
        <p class="title">用户管理</p>
<div>
    <table border="0" cellpadding="10px">
        <tr>
            <th>序号</th>
            <th>ID</th>
            <th><a href="user_mng.php?order=nickname">昵称</a></th>
            <th><a href="user_mng.php?order=sex">性别</a></th>
            <th><a href="user_mng.php?order=adress">地址</a></th>
            <th><a href="user_mng.php?order=intro">介绍</a></th>
            <th><a href="user_mng.php?order=phone">手机</a></th>
            <th><a href="user_mng.php?order=regist_utc">注册日期</a></th>
            <th><a href="user_mng.php?order=login_data">最后登录日期</a></th>
            <th>操作</th>
        </tr>
        <?php

        $sh = new SqlHelper();
        $sh->conn();
        $list = array();
        $sql = 'SELECT id,nickname,sex,adress,intro,phone,regist_data,login_data FROM tbl_user';

        if(isset($_REQUEST['order']))
        {
            $order = $_REQUEST['order'];


            if(isset($_SESSION['user_order_by']) && $_SESSION['user_order_by'] == $order)
            {
                $_SESSION['user_order_desc'] = !$_SESSION['user_order_desc'];
            }
            else
            {
                $_SESSION['user_order_desc'] = false;
            }

            $_SESSION['user_order_by'] = $order;

            $sql.=' ORDER BY '.$order;
            if($_SESSION['user_order_desc'])
            {
                $sql.=' DESC';
            }
        }

        $result = $sh->query($sql);
        if($result)
        {
            $index = 1;
        foreach($result as $v)
        {
            ?>
            <tr>
                <td><?php echo $index++ ?></td>
                <td><?php echo $v['id'] ?></td>
                <td><?php echo $v['nickname'] ?></td>
                <td><?php echo $v['sex'] ?></td>
                <td><?php echo $v['adress'] ?></td>
                <td><?php echo $v['intro'] ?></td>
                <td><?php echo $v['phone'] ?></td>
                <td><?php echo $v['regist_data'] ?></td>
                <td><?php echo $v['login_data'] ?></td>
                <td><a href="user_edit.php?id=<?php echo $v['id'] ?>">修改</a></td>
            </tr>
        <?php }
        }?>
    </table>
</div>
    </td>
</table>
</body>
</html>
