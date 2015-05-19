<?php
/**
 * 标签管理
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/4
 * Time: 14:38
 */

date_default_timezone_set('Asia/Shanghai');
include '../server/configs/define.php';
include '../server/utils/sql_helper.php';

$id = $_REQUEST['id'];

$sh = new SqlHelper();


if(isset($_REQUEST['del'])) {
    $del = $_REQUEST['del'];
    $sh->conn();
    $sql = "DELETE FROM tbl_label WHERE id=$del";
    //die($sql);
    $result = $sh->modify($sql);
    $sh->close();
    if(false == $result) {
        echo "删除失败";
        die();
    } else {
        header("Location:photo_mng.php");
        exit;
    }
} else if(isset($_REQUEST['cnt'])) {
    $lid = $_REQUEST['lid'];
    $cnt = $_REQUEST['cnt'];

    $sh->conn();
    $sql = "UPDATE tbl_label SET content = '$cnt' WHERE id=$lid";
    //die($sql);
    $result = $sh->modify($sql);
    $sh->close();
    if(false == $result) {
        echo "修改失败";
        die();
    } else {
        header("Location:photo_mng.php");
        exit;
    }
}


$sh->conn();
$sql = 'SELECT * FROM tbl_label WHERE photo_id = ' . $id;
$result = $sh->query($sql);
$sh->close();


?>

<!DOCTYPE html>
<html>

<script type="text/javascript">
    function update(id) {
        var url = "tag_mng.php?";
        url += "id=" + <?php echo $id ?>;
        url += "&lid=" + id;
        var input = document.getElementById(id);
        url += "&cnt=" + input.value;
        location.href = url;
    }
</script>

<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<div>
    <table border="0" cellpadding="10px">
        <tr>
            <th>内容</th>
            <th>操作</th>
        </tr>
        <?php
        foreach($result as $v) {
            ?>
            <tr>
                <td><input id="<?php echo $v['id'] ?>" type="text" value="<?php echo $v['content'] ?>"/></td>
                <td>
                    <a href="javascript:;" onclick="update(<?php echo $v['id'] ?>)">修改</a>
                    <a href="tag_mng.php?id=<?php echo $id ?>&del=<?php echo $v['id'] ?>">删除</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>


</html>