<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/8
 * Time: 15:17
 */

include 'common.php';

if(isset($_REQUEST['edit']))
{
    echo '初始化编辑';
    $id = $_REQUEST['edit'];
    $_SESSION['id'] = $id;
}
else
{
    echo '提交编辑结果';
    $id = $_SESSION['id'];
    $name = $_REQUEST['name'];
    $end = $_REQUEST['end'];
    $end = strtotime($end);
    $sql = "UPDATE tbl_activities SET name='$name',end_utc=$end WHERE id=$id";
    unset($_SESSION['id']);
    //die($sql);
    //exit;
    $sh = new SqlHelper();
    $sh->conn();
    $result = $sh->modify($sql);
    $sh->close();
    if(false == $result)
    {
        echo '<script>alert("修改失败!")</script>';
    }
    else
    {
        header("Location:av_mng.php");
        exit;
    }
}

$sql = "SELECT * FROM tbl_activities WHERE id=$id";
$sh = new SqlHelper();
$sh->conn();
$result = $sh->query($sql);
$v = $result[0];

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form method="get" action="av_edit.php" enctype="multipart/form-data">
    <table border="0">
        <tr>
            <td>活动名称：</td>
            <td><input type="text" name="name" value="<?php echo $v['name'] ?>" /></td>
        </tr>
        <tr>
            <td>活动结束日期：</td>
            <td><input type="date" name="end" value="<?php echo trim(date('Y-m-d ',$v['end_utc']))?>" /></td>
        </tr>
    </table>
    <input type="submit" value="修改" />
</form>
</body>
</html>