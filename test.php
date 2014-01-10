<?
include('common.php');

/*
$profile = new ahutProfile();
$info = $profile->getStudentInfo('119074021');
echo $info['xm'].' '.$info['xb'].' '.$info['xy'].' '.$info['bj'];
*/


$food = new ahutFood();
echo $food->nextFood();

?>