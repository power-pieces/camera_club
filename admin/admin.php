<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/7
 * Time: 11:19
 */

include 'common.php';

if(isset($_REQUEST['pwd'])) {
    $pwd = $_REQUEST['pwd'];
    $sql = "UPDATE tbl_admin SET pwd='$pwd' WHERE id='admin'";
    $sh = new SqlHelper();
    $sh->conn();
    $result = $sh->modify($sql);
    if($result) {
        echo '<script>alert("密码更新成功!")</script>';
    }

}


?>


<!DOCTYPE html>
<html>

<script>
    function update() {
        if (document.getElementById('pwd').value == document.getElementById('pwd1').value) {
            document.getElementById('form').submit();
        }
        else {
            alert("两次输入的密码不一致");
        }
    }

</script>

<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/g.css"/>
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
        <p class="title">管理员账户</p>

        <div>
            <form id="form" action="admin.php" method="post">
                <table border="0" cellpadding="10px">
                    <tr>
                        <td>账号</td>
                        <td>admin</td>
                    </tr>
                    <tr>
                        <td>密码</td>
                        <td><input id="pwd" name="pwd" type="password"/></td>
                    </tr>
                    <tr>
                        <td>再次输入密码</td>
                        <td><input id="pwd1" name="pwd1" type="password"/></td>
                    </tr>
                </table>
                <input type="button" onclick="update()" value="确认修改"/>
            </form>
        </div>
    </td>
</table>
</body>
</html>