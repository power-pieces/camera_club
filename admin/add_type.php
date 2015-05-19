<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/8
 * Time: 14:43
 */

include 'common.php';

if(isset($_REQUEST['name']))
{
    $name = $_REQUEST['name'];
    $sql = "INSERT INTO tbl_type(name) VALUES('$name');";
    $sh = new SqlHelper();
    $sh->conn();
    $result = $sh->modify($sql);
    if($result)
    {
        echo "<script>alert('类别增加成功')</script>";
    }
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
            <td>类别名称：</td>
            <td><input type="text" name="name" /></td>
        </tr>
    </table>
    <input type="submit" value="添加" />
</form>
</body>
</html>