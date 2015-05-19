<?php
/**
 * 查看用户信息、排序（如按注册时间排序，按粉丝数排序，按关注人数排序）；查看日注册数量和日活跃人数等；可以修改和删除用户信息；
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/13
 * Time: 10:01
 */

date_default_timezone_set('Asia/Shanghai');
include '../server/configs/define.php';
include '../server/utils/sql_helper.php';


function getListData(&$list, $date)
{
    $data = null;
    if(isset($list[$date]))
    {
        $data = $list[$date];
    }
    else
    {
        $list[$date] = array();
        $data = &$list[$date];
        $data['regist_amount'] = 0;
        $data['login_amount'] = 0;
    }
    return $data;
}
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
            <th>日期</th>
            <th>注册人数</th>
            <th>活跃人数</th>
        </tr>
        <?php
            $registAmount = 0;
            $loginAmount = 0;

            $sh = new SqlHelper();
            $sh->conn();
            $list = array();
            $result = $sh->query('SELECT Count(*) as amount, regist_data FROM tbl_user GROUP BY regist_data ORDER BY regist_data DESC LIMIT 0, 31;');
            foreach($result as $v)
            {
                $data = getListData($list, $v['regist_data']);
                $data['regist_amount'] = +$v['amount'];
                $registAmount += +$v['amount'];
                $list[ $v['regist_data']] = $data;
            }
            $sh->close();

            $sh->conn();
            $result = $sh->query('SELECT Count(*) as amount, login_data FROM tbl_user GROUP BY login_data ORDER BY regist_data DESC LIMIT 0, 31;');

            if($result)
            {
                foreach($result as $v)
                {
                    $data = getListData($list, $v['login_data']);
                    $data['login_amount'] = +$v['amount'];
                    $loginAmount += +$v['amount'];
                    $list[ $v['login_data']] = $data;
                }
            }
            $sh->close();


            foreach($list as $date => $data)
            {
        ?>
        <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $data['regist_amount'] ?></td>
            <td><?php echo $data['login_amount'] ?></td>
        </tr>
        <?php } ?>

        <tr>
            <td>合计</td>
            <td><?php echo $registAmount ?></td>
            <td><?php echo $loginAmount ?></td>
        </tr>
    </table>
</div>
</body>
</html>
