<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2015/5/8
 * Time: 14:26
 */

include 'common.php';

function getListData(&$list, $date)
{
    $data = null;
    if(isset($list[$date])) {
        $data = $list[$date];
    } else {
        $list[$date] = array();
        $data = &$list[$date];
        $data['regist_amount'] = 0;
        $data['login_amount'] = 0;
    }
    return $data;
}

function getPhotoListData(&$list, $date)
{
    $data = null;
    if(isset($list[$date])) {
        $data = $list[$date];
    } else {
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
        <p class="title">数据统计</p>

        <table>
            <td>
                <div>
                    <h2>用户统计</h2>
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
                        foreach($result as $v) {
                            $data = getListData($list, $v['regist_data']);
                            $data['regist_amount'] = +$v['amount'];
                            $registAmount += +$v['amount'];
                            $list[$v['regist_data']] = $data;
                        }
                        $sh->close();

                        $sh->conn();
                        $result = $sh->query('SELECT Count(*) as amount, login_data FROM tbl_user GROUP BY login_data ORDER BY regist_data DESC LIMIT 0, 31;');

                        if($result) {
                            foreach($result as $v) {
                                $data = getListData($list, $v['login_data']);
                                $data['login_amount'] = +$v['amount'];
                                $loginAmount += +$v['amount'];
                                $list[$v['login_data']] = $data;
                            }
                        }
                        $sh->close();


                        foreach($list as $date => $data) {
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
            </td>
            <td>
                <div style="padding-left: 200px">
                    <h2>图片统计</h2>
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
                        foreach($result as $v) {
                            $data = getPhotoListData($list, $v['date']);
                            $data['img_amount'] = +$v['amount'];
                            $imgAmount += +$v['amount'];
                            $list[$v['date']] = $data;
                        }
                        $sh->close();

                        $sh->conn();
                        $result = $sh->query('SELECT Count(*) as amount, date FROM tbl_praise GROUP BY date ORDER BY date DESC LIMIT 0, 31;');

                        foreach($result as $v) {
                            $data = getPhotoListData($list, $v['date']);
                            $data['praise_amount'] = +$v['amount'];
                            $praiseAmount += +$v['amount'];
                            $list[$v['date']] = $data;
                        }
                        $sh->close();

                        $sh->conn();
                        $result = $sh->query('SELECT Count(*) as amount, date FROM tbl_comment GROUP BY date ORDER BY date DESC LIMIT 0, 31;');

                        foreach($result as $v) {
                            $data = getPhotoListData($list, $v['date']);
                            $data['comment_amount'] = +$v['amount'];
                            $commentAmount += +$v['amount'];
                            $list[$v['date']] = $data;
                        }
                        $sh->close();


                        foreach($list as $date => $data) {
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
            </td>
        </table>
    </td>
</table>
</body>
</html>
