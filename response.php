<?php
$GLOBALS['menuStr'] = '��ӭ��ע��������Ϣ���֣���ظ����ֽ�����Ӧ��ģʽ��
1:��Ϣ��ѯ
...
9.��������
0:�������˵�';

$GLOBALS['postObj'] = simplexml_load_string($GLOBALS["HTTP_RAW_POST_DATA"], 'SimpleXMLElement', LIBXML_NOCDATA);
$GLOBALS['toUserName'] = (string) trim($GLOBALS['postObj']->ToUserName);
$GLOBALS['fromUserName'] = (string) trim($GLOBALS['postObj']->FromUserName);
$GLOBALS['msgType'] = (string) trim($GLOBALS['postObj']->MsgType);

if (empty($GLOBALS['fromUserName'])) die('�ӿڴ���');

if ($GLOBALS['msgType'] == 'event') {
    parseEvent();
} else if ($GLOBALS['msgType'] == 'text') {
    parseText();
} else {
    responseText('����δ֪����Ϣ����');
}

function parseEvent()
{
    $event = (string) trim($GLOBALS['postObj']->Event);
    if ($event == 'subscribe') {
        responseText($GLOBALS['menuStr']);
    } else {
        responseText('����δ֪���¼�');
    }
}

function parseText()
{
    $content = (string) trim($GLOBALS['postObj']->Content);
    
    $userObj = new ahutUser();
    $userObj->addUser($GLOBALS['fromUserName']);
    $userMode = $userObj->getUserMode($GLOBALS['fromUserName']);
    if($content == '0') {
        $userObj->setUserMode($GLOBALS['fromUserName'], 0);
        responseText($GLOBALS['menuStr']);
    } else {
        switch($userMode) {
            case 0:
            //��������˵�
            switch($content) {
                case '1':
                $contentStr = '��ظ�Ҫ��ѯ��ѧ��';
                $userObj->setUserMode($GLOBALS['fromUserName'], 1);
                break;
                case '9':
                $contentStr = '��ظ����Լ���ѧ��';
                $userObj->setUserMode($GLOBALS['fromUserName'], 9);
                break;
                default:
                $contentStr = '��������δ֪��ָ���ظ�����ָ��';
            }
            responseText($contentStr, true);
            break;
            case 1:
            $profile = new ahutProfile();
            if($profile->checkXH($content)) {
                $info = $profile->getStudentInfo($content);
                $contentStr = $info['xm'].' '.$info['xb'].' '.$info['xy'].' '.$info['bj'];
            }else{
                $contentStr = '���������ѧ���Ƿ�����';
            }
            responseText($contentStr, true);
            break;
            case 9:
            $profile = new ahutProfile();
            if($profile->checkXH($content)) {
                $userObj->setUserXH($GLOBALS['fromUserName'], $content);
                $userObj->setUserMode($GLOBALS['fromUserName'], 0);
                responseText('ѧ�����óɹ�:'.$content);
            }else{
                responseText('ѧ������ʧ�ܣ����������Ƿ�����', true);
            }
            break;
            default:
            responseText($GLOBALS['menuStr']);
        }
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
		$msg .= '���ظ�0�������˵���';
	}
	$resultStr = sprintf($textTpl, $GLOBALS['fromUserName'], $GLOBALS['toUserName'], $time, $msg);
	echo $resultStr;
	exit;
}
	