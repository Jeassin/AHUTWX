<?php
@require('wechat.class.php');
$options = array(
	'token'=>'ahutapp', //��д���趨��key
	'appid'=>'gh_d6aefcbf9d45', //��д�߼����ù��ܵ�app id
	'appsecret'=>'', //��д�߼����ù��ܵ���Կ
);
$weObj = new Wechat($options);

$newmenu =  array(
	"button" => 
		array(
			array('type'=>'click','name'=>'������Ϣ','key'=>'MENU_KEY_NEWS'),
			array('type'=>'view','name'=>'��Ҫ����','url'=>'http://www.baidu.com'),   				
		)
);
if ($weObj->createMenu($newmenu)) {
	echo 'success';
}
?>