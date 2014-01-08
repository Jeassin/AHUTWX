<?
class ahutProfile
{
	//查询用户信息
	public function getStudentInfo($xh)
	{
		$db = new ahutDB();
		if(!$this->checkXH($xh))return '';
		return $db->getFirstRow("SELECT * FROM `baseprofile2013` WHERE xh = '$xh'");
	}
	
	//检查学号是否有效
	public function checkXH($xh)
	{
		return preg_match('/^[0-9]{9}$/',$xh);
	}
}

?>