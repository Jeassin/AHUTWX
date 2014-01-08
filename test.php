<?
include('db.class.php');
include('profile.class.php');
include('user.class.php');
/*
$profile = new ahutProfile();
$info = $profile->getStudentInfo('119074021');
echo $info['xm'].' '.$info['xb'].' '.$info['xy'].' '.$info['bj'];
*/

$user = new ahutUser();
$user->addUser('123');

?>