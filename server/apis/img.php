<?php
class Img
{
	public function publish(&$params, &$res)
	{
        $sql = "CALL add_photo('%s', %d, '%s', '%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid)
            , mysql_escape_string($params->type)
            , mysql_escape_string($params->title)
            , mysql_escape_string($params->desc)
        );
        $st = new SqlHelper();
        $st->conn();
        $result = $st->query($sql);
        $photoId = $result[0]['identity'];
        //保存图片
        ImgUtil::saveImg($params->imgData, DIR_PHOTO, $photoId);

        $sql = null;
        foreach($params->labels as $label)
        {
            $x =  $label->anchor_x;
            $y =  $label->anchor_y;
            $l =  $label->content;

            if(null == $sql)
            {
                $sql = sprintf("INSERT INTO tbl_label VALUES(%d,%d,%d,'%s')",$photoId, $x, $y, $l);
            }
            else{
                $sql.= sprintf(",(%d,%d,%d,'%s')",$photoId, $x, $y, $l);
            }
            $st->modify($sql);
        }
        $st->close();
        $res['data'] = $photoId;
	}

    public function publish2(&$params, &$res)
    {
        //保存图片
        $file = file_get_contents('http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$params->at.'&media_id='.$params->imgData);
        $wrongObj = null;
        try{
            $wrongObj = json_decode($file);
        }
        catch(Exception $e)
        {

        }

        if(null == $file || "" == $file || $wrongObj)
        {
            $res['data'] = false;
//            $res['error'] = 1;
//            $res['msg'] = $params->at;
            return;
        }

        $sql = "CALL add_photo('%s', %d, '%s', '%s');";
        $sql = sprintf($sql, mysql_escape_string($params->oid)
            , mysql_escape_string($params->type)
            , mysql_escape_string($params->title)
            , mysql_escape_string($params->desc)
        );
        $st = new SqlHelper();
        $st->conn();
        $result = $st->query($sql);
        $photoId = $result[0]['identity'];

        $savePath = DIR_PHOTO.$photoId.'.jpg';
        file_put_contents($savePath,$file);

        $sql = null;
        foreach($params->labels as $label)
        {
            $x =  $label->anchor_x;
            $y =  $label->anchor_y;
            $l =  $label->content;

            if(null == $sql)
            {
                $sql = sprintf("INSERT INTO tbl_label(photo_id, anchor_x, anchor_y, content) VALUES(%d,%d,%d,'%s')",$photoId, $x, $y, $l);
            }
            else{
                $sql.= sprintf(",(%d,%d,%d,'%s')",$photoId, $x, $y, $l);
            }
            //die($sql);


            $st->close();
            $st->conn();
            $st->modify($sql);
        }
        $st->close();
        $res['data'] = $photoId;
    }
	
	public function get_list(&$params, &$res)
	{
        //通过类型搜索
        if(isset($params->type) && $params->type != null)
        {
            $sql = "CALL get_img_list_by_type(%d, %d);";
            $sql = sprintf($sql, mysql_escape_string($params->type),$params->page);
        }
        //通过关键字搜索
        else if(isset($params->search))
        {
            $sql = "CALL get_img_list_by_search('%s', %d);";
            $sql = sprintf($sql, '%'.mysql_escape_string($params->search).'%',$params->page);
        }
        //通过用户ID搜索
        else if(isset($params->userId))
        {
            $sql = "CALL get_img_list_by_user('%s', %d);";
            $sql = sprintf($sql, mysql_escape_string($params->userId),$params->page);
        }
        else{
            $sql = "CALL get_img_list(%d);";
            $sql = sprintf($sql, $params->page);
        }

        //die($sql);

        $rec = array();

        $st = new SqlHelper();
        $st->conn();
        $result = $st->query($sql);
        $rec['imgs'] = $result;
        if($result)
        {
            $ids = null;
            foreach($result as $photo)
            {
                if($ids == null)
                {
                    $ids = $photo['photo_id'];
                }
                else
                {
                    $ids .= ','.$photo['photo_id'];
                }
            }


            $st->close();
            $st->conn();

            $sql = "SELECT photo_id,anchor_x,anchor_y,content FROM tbl_label WHERE photo_id IN ($ids);";
            $labels = $st->query($sql);
            $rec['labels'] = $labels;
        }

        $res['data'] = $rec;
	}
	
	public function details(&$params, &$res)
	{
        $rec = array();

        $st = new SqlHelper();
        $st->conn();


        $sql = "CALL get_photo_details(%d);";
        $sql = sprintf($sql, mysql_escape_string($params->photoId));
        $result = $st->query($sql);
        if(1 != count($result))
        {
            $res['error'] = 1;
            $res['msg'] = 'no photo';
            return;
        }
        foreach($result[0] as $k => $v)
        {
            $rec[$k] = $v;
        }

        $st->close();

        if($rec['author_id'] != $params->oid)
        {
            $st = new SqlHelper();
            $st->conn();
            //访问的是别人的图片
            $sql = "CALL add_visit('%s', %d);";
            $sql = sprintf($sql, mysql_escape_string($params->oid), mysql_escape_string($params->photoId));
            $st->modify($sql);
            $st->close();
        }


        $st = new SqlHelper();
        $st->conn();

        $sql = "CALL get_visit_list(%d);";
        $sql = sprintf($sql, mysql_escape_string($params->photoId));
        $result = $st->query($sql);
        $rec['visitor'] = $result;

        $st->close();
        $st = new SqlHelper();
        $st->conn();

        $sql = "CALL get_comment_list(%d);";
        $sql = sprintf($sql, mysql_escape_string($params->photoId));
        $st->conn();
        $rec['comments'] = $st->query($sql);

        $st->close();
        $st = new SqlHelper();
        $st->conn();

        $sql = "SELECT anchor_x,anchor_y,content FROM tbl_label WHERE photo_id = %d;";
        $sql = sprintf($sql, mysql_escape_string($params->photoId));
        $result = $st->query($sql);
        $rec['labels'] = $result;

        $res['data'] = $rec;

        $st->close();
	}
	
	public function praise(&$params, &$res)
	{
        $st = new SqlHelper();
        $st->conn();

        $sql = "CALL add_praise(%d, '%s');";
        $sql = sprintf($sql, mysql_escape_string($params->photoId), mysql_escape_string($params->oid));
        $result = $st->modify($sql);
        $res['data'] = $result;

        $st->close();
	}

    public function comment(&$params, &$res)
    {
        $st = new SqlHelper();
        $st->conn();

        $sql = "CALL add_comment(%d, '%s', '%s');";
        $sql = sprintf($sql, mysql_escape_string($params->photoId)
            , mysql_escape_string($params->oid)
            , mysql_escape_string($params->content)
        );
        $result = $st->modify($sql);
        $res['data'] = $result;

        $st->close();
    }

    public function comment_reply(&$params, &$res)
    {
        $st = new SqlHelper();
        $st->conn();

        $sql = "CALL add_comment_reply(%d, '%s');";
        $sql = sprintf($sql, mysql_escape_string($params->comment_id), mysql_escape_string($params->content));
        $result = $st->modify($sql);
        $res['data'] = $result;

        $st->close();
    }

    public function type_list(&$params, &$res)
    {
        $st = new SqlHelper();
        $st->conn();

        $sql = "SELECT * FROM tbl_activities";
        $result = $st->query($sql);
        $res['data'] = $result;

        $st->close();
    }

    public function get_praise_list(&$params, &$res)
    {
        $st = new SqlHelper();
        $st->conn();

        $sql = "SELECT photo_id FROM tbl_praise WHERE praiser_id = '%s';";
        $sql = sprintf($sql, mysql_escape_string($params->oid));
        $result = $st->query($sql);
        $res['data'] = $result;

        $st->close();
    }
}