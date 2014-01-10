<?php
if (empty($GLOBALS["HTTP_RAW_POST_DATA"])) exit;

$GLOBALS['menuStr'] = '欢迎关注安工大信息助手，请回复数字进入相应的模式：
    1:信息查询
    2.吃点啥
    ...
    9.个人设置
    0:返回主菜单
回复"apk"获取安工大安卓应用的下载地址';

const MENU_TIP1 = '请回复要查询的学号或姓名或者拼音首字母';
const MENU_TIP2 = "回复“吃点啥”获取一条吃啥建议\n回复“我想吃___”推荐一则食物";

$GLOBALS['postObj'] = simplexml_load_string($GLOBALS["HTTP_RAW_POST_DATA"], 'SimpleXMLElement', LIBXML_NOCDATA);
$GLOBALS['toUserName'] = trim($GLOBALS['postObj']->ToUserName);
$GLOBALS['fromUserName'] = trim($GLOBALS['postObj']->FromUserName);
$GLOBALS['msgType'] = trim($GLOBALS['postObj']->MsgType);

if ($GLOBALS['msgType'] == 'event') {
    parseEvent();
} else if ($GLOBALS['msgType'] == 'text') {
    parseText();
} else {
    responseText('错误：未知的消息类型');
}

function parseEvent()
{
    $event = trim($GLOBALS['postObj']->Event);
    if ($event == 'subscribe') {
        responseText($GLOBALS['menuStr'] . "\n" . '欢迎关注我的新浪微博: 任震_renzhn');
    } else if ($event == 'unsubscribe') {
        $userObj = new ahutUser($GLOBALS['fromUserName']);
        $userObj->deleteUser();
    } else {
        responseText('错误：未知的事件');
    }
}

function parseText()
{
    $content = trim($GLOBALS['postObj']->Content);

    $userObj = new ahutUser($GLOBALS['fromUserName']);
    $userObj->addUser();
    $userMode = $userObj->getUserMode();
    if ($content == '0') {
        $userObj->setUserMode(0);
        responseText($GLOBALS['menuStr']);
    }
    switch ($userMode) {
        case 0:
            //进入二级菜单
            $contentStr = '';
            switch ($content) {
                case '1':
                    $contentStr = MENU_TIP1;
                    $userObj->setUserMode(1);
                    break;
                case '2':
                    $contentStr = MENU_TIP2;
                    $userObj->setUserMode(2);
                    break;
                case '9':
                    $xh = $userObj->getUserXH();
                    if (!empty($xh)) {
                        responseText('您已绑定学号:' . $xh);
                    } else {
                        $contentStr = '请回复你自己的学号';
                        $userObj->setUserMode(9);
                    }
                    break;
                case 'apk':
                    $contentStr = '课友：http://ahutapp.sinaapp.com/ahutlesson.apk' . "\n" . '校园网客户端：http://ahutapp.sinaapp.com/ahutconn.apk' . "\n". '请将下载地址复制到其他浏览器打开';
                    break;
                default:
                    $contentStr = '你输入了未知的指令，请回复数字指令';
            }
            responseText($contentStr, true);
            break;
        case 1:
            $profile = new ahutProfile();
            responseText($profile->getInfo($content), true);
            break;
        case 2:
            if ($content == '吃点啥') {
                $food = new ahutFood();
                responseText($food->nextFood(), true);
            } else if (startsWith($content, '我想吃')) {
                responseText('好吧...', true);
            } else responseText('what?'. "\n". MENU_TIP2, true);
            break;
        case 9:
            if (isXH($content)) {
                $userObj->setUserXH($content);
                $userObj->setUserMode(0);
                responseText('学号设置成功:' . $content);
            } else {
                responseText('学号设置失败，请检查输入是否有误', true);
            }
            break;
        default:
            responseText($GLOBALS['menuStr']);
    }
}

function responseText($msg, $tip = false)
{
    $time = time();
    $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
    if ($tip == true) {
        $msg .= "\n" . '（回复0返回主菜单）';
    }
    $resultStr = sprintf($textTpl, $GLOBALS['fromUserName'], $GLOBALS['toUserName'], $time, $msg);
    echo $resultStr;
    exit;
}