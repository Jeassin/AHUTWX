<?php
include('db.class.php');
include('user.class.php');
include('profile.class.php');
include('food.class.php');

define("TOKEN", "ahutapp");
const PROFILE_TABLE = 'baseprofile2013';
const LESSON_TABLE = 'lesson2013_1';
const RESULT_MAX = 40;
const TEXT_BANNER = '-----------------';

$GLOBALS['weeks'] = array('周一', '周二', '周三', '周四', '周五', '周六', '周日');
$GLOBALS['times'] = array('上午前两节', '上午后两节', '下午前两节', '下午后两节', '晚上');


//检查学号是否有效
function isXH($xh)
{
    return preg_match('/^[0-1][0-9]9[0-1][0-9]4[0-9]{3,4}$/', $xh);
}

function isXM($input)
{
    return preg_match('/^[\x80-\xff]{6,12}$/', $input);
}

function isPY($input)
{
    return preg_match('/^[A-Za-z]{2,3}$/', $input);
}

function isBJ($input)
{
    return preg_match('/^[\x80-\xff]{3}[0-1][0-9][0-9]$/', $input);
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

const MORNING = 'morning';
const AFTERNOON = 'afternoon';
const EVENING = 'evening';
const NIGHT = 'night';

function getTimePeriod()
{
    $hour = date("H");
    if ($hour < 10) {
        return MORNING;
    } else if ($hour < 15) {
        return AFTERNOON;
    } else if ($hour < 19) {
        return EVENING;
    } else {
        return NIGHT;
    }
}