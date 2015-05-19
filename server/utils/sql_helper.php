<?php
/**
 * 数据库帮助类
 * @author Jing
 *
 */
class SqlHelper
{
	public $conn = null;

	
	//连接数据库
	public function conn()
	{
		$this->conn = @mysql_connect(DB_URL,'root',DB_PWD);
		mysql_select_db(DB_NAME, $this->conn);
        mysql_query('SET NAMES UTF8');
	}
	
	//查询数据库
	public function query($sql)
	{
		mysql_ping($this->conn);
		$result = mysql_query($sql, $this->conn);
		if($result)
		{
			return $this->transformSqlResult2Array($result);
		}
		return false;
	}
	
	//修改数据库
	public function modify($sql)
	{
		mysql_ping($this->conn);
        $result = mysql_query($sql, $this->conn);
		return $result;
	}
	
	//关闭数据库
	public function close()
	{
		@mysql_close($this->conn);
		$this->conn = null;
	}	
	
	/**
	 * 将SQL查询结果转换为数据进行返回
	 * @param $result
	 */
	private function transformSqlResult2Array(&$result)
	{
		
		$arr = array();
		while($row = mysql_fetch_assoc($result))
		{
			array_push($arr,$row);
		}
		return $arr;
	}
}