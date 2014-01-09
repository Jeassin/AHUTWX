<?
include('common.php');
include('db.class.php');
include('profile.class.php');
include('user.class.php');
/*
$profile = new ahutProfile();
$info = $profile->getStudentInfo('119074021');
echo $info['xm'].' '.$info['xb'].' '.$info['xy'].' '.$info['bj'];
*/

$profile = new ahutProfile();
echo $profile->getInfo('rz的课表');

?>