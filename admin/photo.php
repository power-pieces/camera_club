<?php
/**
 * 查看图片，排序；查看日上传照片、点赞量、评论量等；
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/4/13
 * Time: 10:19
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
        $data['img_amount'] = 0;
        $data['praise_amount'] = 0;
        $data['comment_amount'] = 0;
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
            <th>图片数</th>
            <th>点赞量</th>
            <th>评论量</th>
        </tr>
        <?php
        $imgAmount = 0;
        $praiseAmount = 0;
        $commentAmount = 0;

        $sh = new SqlHelper();
        $sh->conn();
        $list = array();
        $result = $sh->query('SELECT Count(*) as amount, date FROM tbl_photo GROUP BY date ORDER BY utc DESC LIMIT 0, 31;');
        foreach($result as $v)
        {
            $data = getListData($list, $v['date']);
            $data['img_amount'] = +$v['amount'];
            $imgAmount += +$v['amount'];
            $list[ $v['date']] = $data;
        }
        $sh->close();

        $sh->conn();
        $result = $sh->query('SELECT Count(*) as amount, date FROM tbl_praise GROUP BY date ORDER BY date DESC LIMIT 0, 31;');

        foreach($result as $v)
        {
            $data = getListData($list, $v['date']);
            $data['praise_amount'] = +$v['amount'];
            $praiseAmount += +$v['amount'];
            $list[ $v['date']] = $data;
        }
        $sh->close();

        $sh->conn();
        $result = $sh->query('SELECT Count(*) as amount, date FROM tbl_comment GROUP BY date ORDER BY date DESC LIMIT 0, 31;');

        foreach($result as $v)
        {
            $data = getListData($list, $v['date']);
            $data['comment_amount'] = +$v['amount'];
            $commentAmount += +$v['amount'];
            $list[ $v['date']] = $data;
        }
        $sh->close();


        foreach($list as $date => $data)
        {
            ?>
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $data['img_amount'] ?></td>
                <td><?php echo $data['praise_amount'] ?></td>
                <td><?php echo $data['comment_amount'] ?></td>
            </tr>
        <?php } ?>

        <tr>
            <td>合计</td>
            <td><?php echo $imgAmount ?></td>
            <td><?php echo $praiseAmount ?></td>
            <td><?php echo $commentAmount ?></td>
        </tr>
    </table>
</div>
</body>
</html>
