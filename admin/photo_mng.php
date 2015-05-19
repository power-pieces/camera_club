<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/24
 * Time: 23:10
 */

include 'common.php';

if(isset($_REQUEST['del']))
{
    $id = $_REQUEST['del'];
    $sh = new SqlHelper();
    $sh->conn();
    $list = array();
    $result = $sh->modify('DELETE FROM tbl_photo WHERE photo_id = '.$id);
    if(false == $result)
    {
        echo "删除出错";
        die();
    }
    $sh->close();
}


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
    <td class="ctnt_td" >
<p class="title">图片管理</p>
<div>
    <table border="0" cellpadding="10px">
        <tr>
            <th>序号</th>
            <th>ID</th>
            <th>图片</th>
            <th><a href="photo_mng.php?order=author_id">作者ID</a></th>
            <th><a href="photo_mng.php?order=type">活动编号</a></th>
            <th><a href="photo_mng.php?order=title">标题</a></th>
            <th><a href="photo_mng.php?order=`desc`">描述</a></th>
            <th><a href="photo_mng.php?order=utc">上传日期</a></th>
            <th><a href="photo_mng.php?order=praise_amount">点赞数量</a></th>
            <th><a href="photo_mng.php?order=comment_amount">评论数量</a></th>
            <th><a href="photo_mng.php?order=visit_amount">访问数量</a></th>
            <th><a href="photo_mng.php?order=label_amount">标签数量</a></th>
            <th>操作</th>
        </tr>
        <?php

        $sh = new SqlHelper();
        $sh->conn();
        $list = array();
        $sql = '
SELECT *,
(SELECT COUNT(*) FROM tbl_praise WHERE photo_id = TBL.photo_id) AS praise_amount	,
(SELECT COUNT(*) FROM tbl_comment WHERE photo_id = TBL.photo_id) AS comment_amount	,
(SELECT COUNT(*) FROM tbl_visit WHERE photo_id = TBL.photo_id) AS visit_amount,
(SELECT COUNT(*) FROM tbl_label WHERE photo_id = TBL.photo_id) AS label_amount
FROM tbl_photo AS TBL ';

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

//die($sql);
        $result = $sh->query($sql);
        $index = 1;
        foreach($result as $v)
        {
            ?>
            <tr>
                <td><?php echo $index++ ?></td>
                <td><a href="../images/photo/<?php echo $v['photo_id'] ?>.jpg"><img width="100" src="../images/photo/<?php echo $v['photo_id'] ?>.jpg" /></a></td>
                <td><?php echo $v['photo_id'] ?></td>
                <td><?php echo $v['author_id'] ?></td>
                <td><?php echo $v['type'] ?></td>
                <td><?php echo $v['title'] ?></td>
                <td><?php echo $v['desc'] ?></td>
                <td><?php echo $v['date'] ?></td>
                <td><?php echo $v['praise_amount'] ?></td>
                <td><?php echo $v['comment_amount'] ?></td>
                <td><?php echo $v['visit_amount'] ?></td>
                <td><?php echo $v['label_amount'] ?></td>
                <td>
                    <a href="photo_edit.php?id=<?php echo $v['photo_id'] ?>">修改</a>
                    <a href="photo_mng.php?del=<?php echo $v['photo_id'] ?>">删除</a>
                    <a href="tag_mng.php?id=<?php echo $v['photo_id'] ?>">管理标签</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

    </td>
</table>
</body>
</html>