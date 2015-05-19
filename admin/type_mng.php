<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/8
 * Time: 14:32
 */

include 'common.php';

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<div>
    <table border="0" cellpadding="10px">
        <tr>
            <th>序号</th>
            <th>ID</th>
            <th>类别名称</th>
            <th><a href="">操作</a></th>
        </tr>
        <?php

        $sh = new SqlHelper();
        $sh->conn();
        $list = array();
        $sql = 'SELECT * FROM tbl_type';

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
                    <td><?php echo $v['name'] ?></td>
                    <td>
                        <a href="edit_type.php?id=<?php echo $v['id'] ?>&name=<?php echo $v['name'] ?>">修改</a>
                        <a href="type_mng.php?del=<?php echo $v['id'] ?>">删除</a>
                    </td>
                </tr>
            <?php }
        }?>
    </table>
    <a href="add_type.php">添加一个类别</a>
</div>
</body>
</html>
