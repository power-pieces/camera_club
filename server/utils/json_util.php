<?php
class JsonUtil
{	
	/**
	 * 针对中文做的JSON转码 
	 */
	public static function json_encode_cn($str) 
	{
		function encode_json($str) {  
		    return urldecode(json_encode(url_encode($str)));      
		}  
		  
		function url_encode($str) {  
		    if(is_array($str)) {  
		        foreach($str as $key=>$value) {  
		            $str[urlencode($key)] = url_encode($value);  
		        }  
		    } else {  
		        $str = urlencode($str);  
		    }  
		      
		    return $str;  
		}  
		
		return encode_json($str);
	} 
	

}





