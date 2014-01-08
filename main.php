<?php
include('db.class.php');
include('profile.class.php');
include('user.class.php');
define("TOKEN", "ahutapp");
if(!empty($_GET["echostr"])){
	$wechatObj = new wxAPI();
	$wechatObj->valid();
}

if(!empty($GLOBALS["HTTP_RAW_POST_DATA"])){
	@require('response.php');
}

class wxAPI
{
	//此函数用于微信接口验证
	public function valid()
	{
		$echoStr = $_GET["echostr"];
		if($this->checkSignature()){
			echo $echoStr;
			exit;
		}
	}
	
	private function checkSignature()
	{
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];	
				
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>