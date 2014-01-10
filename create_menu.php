<?php
@require('wechat.class.php');
$options = array(
    'token' => 'ahutapp', //填写你设定的key
    'appid' => 'gh_d6aefcbf9d45', //填写高级调用功能的app id
    'appsecret' => '', //填写高级调用功能的密钥
);
$weObj = new Wechat($options);

$newmenu = array(
    "button" =>
    array(
        array('type' => 'click', 'name' => '最新消息', 'key' => 'MENU_KEY_NEWS'),
        array('type' => 'view', 'name' => '我要搜索', 'url' => 'http://www.baidu.com'),
    )
);
if ($weObj->createMenu($newmenu)) {
    echo 'success';
}
?>