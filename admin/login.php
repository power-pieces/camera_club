<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/7
 * Time: 10:41
 */

date_default_timezone_set('Asia/Shanghai');
include '../server/configs/define.php';
include '../server/utils/sql_helper.php';
session_start();

if(isset($_REQUEST['pwd']))
{
    $pwd = $_REQUEST['pwd'];
    $sh = new SqlHelper();
    $sh->conn();
    $sql = "SELECT id FROM tbl_admin WHERE id='admin' AND pwd='$pwd';";
    $result = $sh->query($sql);
    if(sizeof($result) > 0)
    {
        $_SESSION['isLogin'] = true;
    }
    else
    {
        session_unset('isLogin');
        echo "login fail!";
    }
}

if(isset($_SESSION['isLogin']))
{
    header("Location:menu.php");
    exit;
}


?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="login.php" method="post">
    <table border="0" cellpadding="10px">
        <tr>
            <td>账号</td>
            <td>admin </td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input name="pwd" type="text" /> </td>
        </tr>
    </table>
    <input type="submit" value="登陆" />
</form>
</body>
</html>