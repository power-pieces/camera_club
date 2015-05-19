<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/24
 * Time: 23:30
 */

include 'common.php';


$id = $_REQUEST['id'];
$sh = new SqlHelper();
$sh->conn();
$list = array();
$result = $sh->query("SELECT * from tbl_user WHERE id='$id'");
$user = $result[0];
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<script>
    function updateInfo()
    {
        var obj = {};
        obj.oid = '<?php echo $id ?>';
        obj.nickname = $('#nickname')[0].value;
        obj.sex = +$('#sex')[0].value;
        if(obj.sex != 1)
        {
            obj.sex = 0;
        }
        obj.adress = $('#adress')[0].value;
        obj.intro = $('#intro')[0].value;
        obj.phone = $('#phone')[0].value;

        Net.get("user","update_info",obj,
            function(data)
            {
                if(true == data)
                {
                    location.href = "user_mng.php";
                }

            }
        );
    }
</script>
<body>
    <form>
        <table border="0" cellpadding="10px">
            <tr>
                <td>昵称</td>
                <td><input type="text" id="nickname" value="<?php echo $user['nickname'] ?>"></td>
            </tr>
            <tr>
                <td>性别 0:男 1：女</td>
                <td><input type="tel" id="sex" value="<?php echo $user['sex'] ?>"></td>
            </tr>
            <tr>
                <td>地址</td>
                <td><input type="text" id="adress" value="<?php echo $user['adress'] ?>"></td>
            </tr>
            <tr>
                <td>介绍</td>
                <td><input type="text" id="intro" value="<?php echo $user['intro'] ?>"></td>
            </tr>
            <tr>
                <td>电话</td>
                <td><input type="tel" id="phone" value="<?php echo $user['phone'] ?>"></td>
            </tr>
        </table>
        <input type="button" onclick="updateInfo()" value="提交" />
    </form>
</body>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="../client/js/common.js"></script>

</html>