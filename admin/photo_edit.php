<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/7
 * Time: 15:49
 */

include 'common.php';

if(isset($_REQUEST['id']))
{
    $id = $_REQUEST['id'];
    $_SESSION['photo_edit_id'] = $id;
}
else
{
    $id =$_SESSION['photo_edit_id'];
}

if(isset($_REQUEST['title']))
{
    $title = $_REQUEST['title'];
    $desc = $_REQUEST['desc'];

    $sql = "UPDATE tbl_photo SET title='$title',`desc`='$desc' WHERE photo_id=$id;";
   // die($sql);
    $sh = new SqlHelper();
    $sh->conn();
    $result = $sh->modify($sql);
    if($result)
    {
        header("Location:photo_mng.php");
        exit;
    }
    else
    {
        echo "update fail!";
    }
}



$sh = new SqlHelper();
$sh->conn();
$list = array();
$result = $sh->query("SELECT * from tbl_photo WHERE photo_id=$id");
$user = $result[0];

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="photo_edit.php" method="post">
    <table border="0" cellpadding="10px">
        <tr>
            <td>标题</td>
            <td><input type="text" name="title" value="<?php echo $user['title'] ?>"></td>
        </tr>
        <tr>
            <td>描述</td>
            <td><input type="text" name="desc" value="<?php echo $user['desc'] ?>"></td>
        </tr>
    </table>
    <input type="submit" value="提交" />
</form>
</body>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="../client/js/common.js"></script>

</html>