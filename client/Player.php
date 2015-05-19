<?php
class Player {
	public $openid = "";
	//用户昵称
	public $username = "杭州知达网络";
	//头像地址
	public $avatar = "";
	//城市
	public $area = "";
	public $sex = "-1";

    public $access_token = "";

	private $inviter = "";
	private $db;
	private $mainURL = "";
	
	/**
	 * 
	 * @param $mainpage当前页面重新刷新时访问的地址，一般为页面进入的地址
	 */
	public function __construct($mainpage)
	{
		$this->mainURL = $mainpage;
	}
	
	/**
	 * 获取用户的头像昵称等信息 
	 * @param unknown $code
	 * @param unknown $appid
	 * @param unknown $secret
	 */
	public function getInfoFrom($code, $appid, $secret){
		//获取微信全局Access_Token
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
		$result = $this->request_by_other_get($url);
		//echo $url;
		//echo $result;
		$jsoninfo = json_decode($result, true);
		if (isset($jsoninfo["errcode"]))
		{
			$this->refresh();
		}
		$access_token = $jsoninfo["access_token"];
		$this->openid = $jsoninfo["openid"];
		
		//获取用户信息
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$this->openid;
		$res = $this->request_by_other_get($url);
			
		//解析获取到的JSON数据
		$json = json_decode($res,true);
		if (isset($json["errcode"]))
		{
			$this->refresh();
			exit;
		}
		$this->username = $json["nickname"];
		$this->avatar = $json["headimgurl"];
		$this->sex = $json["sex"];
		$this->area = $json["city"];
		
		//echo $res;
	}
	
	/**
	 * 只回去用户的openid
	 * @param unknown $code
	 * @param unknown $appid
	 * @param unknown $secret
	 */
	public function getBaseInfoFrom($code, $appid, $secret){
		//获取微信全局Access_Token
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
		$result = $this->request_by_other_get($url);
		//echo $result;
		$jsoninfo = json_decode($result, true);
		if (isset($jsoninfo["errcode"]))
		{
			$this->refresh();
			exit;
		}else{
			$access_token = $jsoninfo["access_token"];
			$this->openid = $jsoninfo["openid"];
		}
	}
	
	/**
	 * 刷新页面，重新进入
	 */
	private function refresh()
	{
		header("Location:".$this->mainURL);
		exit;
	}
	
	
	private function request_by_other_get($remote_server){
	
		$ch = curl_init();
		$timeout = 35;
		curl_setopt ($ch, CURLOPT_URL, $remote_server);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		//$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $data;
	}
	
	public function setOpenid($openid) {
		$this->openid = $openid;
	}
	
	public function getOpenid() {
		return $this->openid;
	}
	
	/*save data to session*/
	public function saveToSession() {
		$_SESSION["openid"] = $this->openid;
	}
	
	
	/*judge is from timeline*/
	public function isFromFriends($inviter) {
		if($inviter == "") {
			return false;
		}
		return true;
	}

}

?>