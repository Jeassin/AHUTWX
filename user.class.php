<?
class ahutUser
{
	private $db;
	
	public function __construct()
	{
		$this->db = new ahutDB();
	}
	
	//检查是否已有用户信息
	public function checkUser($key)
	{
		$sql = "SELECT COUNT(*) FROM `wx_user` WHERE `key` LIKE '$key'";
		return ($this->db->getFirstGrid($sql) > 0);
	}
	
	//添加新用户
	public function addUser($key)
	{
		if($this->checkUser($key))return;
		
		$sql = "INSERT INTO `wx_user` (`key`) VALUES ('$key')";
		$this->db->runSQL($sql);
	}
	
	//设置用户当前的状态（mode对应菜单中的数字）
	public function setUserMode($key, $mode)
	{
		$sql = "UPDATE `wx_user` SET `mode` = '$mode' WHERE `key` LIKE '$key'";
		$this->db->runSQL($sql);
	}
	
	//获取用户当前的状态
	public function getUserMode($key)
	{
		$sql = "SELECT `mode` FROM `wx_user` WHERE `key` LIKE '$key'";
		return $this->db->getFirstGrid($sql);
	}
	
	//绑定用户的学号
	public function setUserXH($key,$xh)
	{
		$sql = "UPDATE `wx_user` SET `xh` = '$xh' WHERE `key` LIKE '$key'";
		$this->db->runSQL($sql);
	}
}
?>