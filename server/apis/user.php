<?php

class User
{
	/**
	 * 用户登陆
	 */
	public function login(&$params, &$res)
	{
		$sql = "CALL add_user('%s','%s','%s',%d,'%s');";
		$sql = sprintf($sql,   mysql_escape_string($params->openId),
       mysql_escape_string($params->nickname),
       mysql_escape_string($params->headimgurl),
		$params->sex,
       mysql_escape_string($params->adress));

        //die($sql);

		$st = new SqlHelper();
		$st->conn();
		$result = $st->query($sql);
		if($result)
		{
			$res['data'] = $result;
		}
		else
		{
			$res['data'] = false;
		}
	}
	
	/**
	 * 获取用户信息
	 */
	public function get(&$params, &$res)
	{
		$sql = "CALL get_user('%s');";
		$sql = sprintf($sql, mysql_escape_string($params->userId));
        $st = new SqlHelper();
        $st->conn();
        $result = $st->query($sql);
        if($result)
        {
            $res['data'] = $result;
        }
        else
        {
            $res['error'] = 1;
            $res['msg'] = 'sql wrong';
        }
	}


	public function follow(&$params, &$res)
	{
        $a = $params->oid;
        $b = $params->userId;
        $sql = "CALL add_follow('%s','%s');";
        $sql = sprintf($sql, mysql_escape_string($a)
        ,mysql_escape_string($b));
        $st = new SqlHelper();
        $st->conn();
        $result = $st->modify($sql);
        if($result)
        {
            $res['data'] = $result;
        }
        else
        {
            $res['error'] = 1;
            $res['msg'] = 'sql wrong';
        }
	}
	
	public function update_head(&$params, &$res)
	{
        //保存图片
        ImgUtil::saveImg($params->imgData,DIR_HEAD,$params->oid);
        $sql = "CALL update_head_img('%s','%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid)
            ,mysql_escape_string($params->oid));

        $st = new SqlHelper();
        $st->conn();
        $result = $st->modify($sql);
        if($result)
        {
            $res['data'] = $result;
        }
        else
        {
            $res['error'] = 1;
            $res['msg'] = 'sql wrong';
        }
	}

    public function update_head2(&$params, &$res)
    {
        $fileUrl = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$params->at.'&media_id='.$params->mediaId;
        //保存图片
        $file = file_get_contents($fileUrl);
        $wrongObj = null;
        try{
            $wrongObj = json_decode($file);
        }
        catch(Exception $e)
        {

        }

        if($wrongObj)
        {
            $res['data'] = false;
//            $res['error'] = 1;
//            $res['msg'] = $fileUrl;
            return;
        }

        $savePath = DIR_HEAD.$params->oid.'.jpg';
        file_put_contents($savePath,$file);

//        ImgUtil::saveImg($params->imgData,DIR_HEAD,$params->oid);


        $sql = "CALL update_head_img('%s','%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid)
            ,mysql_escape_string($params->oid));

        $st = new SqlHelper();
        $st->conn();
        $result = $st->modify($sql);
        if($result)
        {
            $res['data'] = $result;
        }
        else
        {
            $res['error'] = 1;
            $res['msg'] = 'sql wrong';
        }
    }
	
	public function update_info(&$params, &$res)
	{
        $sql = "CALL update_info('%s', '%s',%d, '%s', '%s', '%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid)
            ,mysql_escape_string($params->nickname)
            ,mysql_escape_string($params->sex)
            ,mysql_escape_string($params->adress)
            ,mysql_escape_string($params->intro)
            ,mysql_escape_string($params->phone)
        );
        $st = new SqlHelper();
        $st->conn();
        $result = $st->modify($sql);
        if($result)
        {
            $res['data'] = $result;
        }
        else
        {
            $res['error'] = 1;
            $res['msg'] = 'sql wrong';
        }
	}
	
	public function msg_list(&$params, &$res)
	{
        $st = new SqlHelper();
        $st->conn();

        $rec = array();

        $sql = "CALL get_receive_msg_list('%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid));
        $result = $st->query($sql);
        $rec['received'] = $result;

        $sql = "CALL get_sent_msg_list('%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid));
        $result = $st->query($sql);
        $rec['sent'] = $result;

        $res['data'] = $rec;
	}

	public function send_msg(&$params, &$res)
	{
        $sql = "CALL add_msg('%s','%s', '%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid)
            ,mysql_escape_string($params->id)
            ,mysql_real_escape_string($params->content)
        );

        $st = new SqlHelper();
        $st->conn();
        $result = $st->modify($sql);
        if($result)
        {
            $res['data'] = $result;
        }
        else
        {
            $res['error'] = 1;
            $res['msg'] = 'sql wrong';
        }
	}
}