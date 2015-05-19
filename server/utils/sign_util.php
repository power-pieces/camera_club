<?php
/**
 * 签名工具
 */
class SignUtil
{
	/**
	 * 检查签名
	 */
	public static function check($array, $sign)
	{
		$str = '';
		foreach( $array as $v)
		{
			$str = $str.$v;			
		}
		
		if(md5($str) == $sign)
		{
			return true;
		}
		return false;
	}
}