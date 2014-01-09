<?php

const PROFILE_TABLE = 'baseprofile2013';
const LESSON_TABLE = 'lesson2013_1';

const TEXT_BANNER = '-----------------';
$GLOBALS['weeks'] = array('周一','周二','周三','周四','周五','周六','周日');
$GLOBALS['times'] = array('上午前两节','上午后两节','下午前两节','下午后两节','晚上');

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

?>