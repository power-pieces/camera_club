<?php
class NetUtil
{
	/**
	 * 通过原始URL地址和参数构建一条带参数的URL地址
	 */
	public static function createUrl($pureUrl,&$vars)
	{
		if(null == $vars)
		{
			return $pureUrl;
		}
		$count = count($vars);
		$url = $pureUrl."?";
		foreach($vars as $k => $v)
		{
			$count--;
			$url = $url.$k.'='.$v;
			if(0 != $count)
			{
				$url = $url.'&';
			}
		}
		return $url;
	}
}