<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/8
 * Time: 14:50
 */

 include 'common.php';

if(isset($_SESSION['name']))
{
    echo "执行修改";
    $name = $_SESSION['name'];
    $id = $_SESSION['id'];

    session_unset('name');
    session_unset('id');

    $sql = "UPDATE tbl_type SET name='$name' WHERE id=$id";
    die($sql);
    $sh = new SqlHelper();
    $sh->conn();
    $result = $sh->modify($sql);
    if($result)
    {
        header("Location:type_mng.php");
        exit;
    }
    else
    {
        echo "<script>alert('修改失败！')</script>";
    }


}
else
{
    echo "获取数据";
    $_SESSION['name'] = $_REQUEST['name'];
    $_SESSION['id'] = $_REQUEST['id'];
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form method="post" action="edit_type.php" enctype="multipart/form-data">
    <table border="0">
        <tr>
            <td>类别名称：</td>
            <td><input type="text" value="<?php echo $_REQUEST['name'] ?>" name="name" /></td>
        </tr>
    </table>
    <input type="submit" value="修改" />
</form>
</body>
</html>