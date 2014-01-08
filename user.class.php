<?
class ahutUser
{
	private $db;
	private $key;
	
	public function __construct($key)
	{
		$this->db = new ahutDB();
		$this->key = $key;
	}
	
	//检查是否已有用户信息
	public function checkUser()
	{
		$sql = "SELECT COUNT(*) FROM `wx_user` WHERE `key` LIKE '$this->key'";
		return ($this->db->getFirstGrid($sql) > 0);
	}
	
	//添加新用户
	public function addUser()
	{
		if($this->checkUser($this->key))return;
		
		$sql = "INSERT INTO `wx_user` (`key`) VALUES ('$this->key')";
		$this->db->runSQL($sql);
	}
	
	//设置用户当前的状态（mode对应菜单中的数字）
	public function setUserMode($mode)
	{
		$sql = "UPDATE `wx_user` SET `mode` = '$mode' WHERE `key` LIKE '$this->key'";
		$this->db->runSQL($sql);
	}
	
	//获取用户当前的状态
	public function getUserMode()
	{
		$sql = "SELECT `mode` FROM `wx_user` WHERE `key` LIKE '$this->key'";
		return $this->db->getFirstGrid($sql);
	}
	
	//绑定用户的学号
	public function setUserXH($xh)
	{
		$sql = "UPDATE `wx_user` SET `xh` = '$xh' WHERE `key` LIKE '$this->key'";
		$this->db->runSQL($sql);
	}
	
	//获取用户的学号
	public function getUserXH($xh)
	{
		$sql = "SELECT `xh` FROM `wx_user` WHERE `key` LIKE '$this->key'";
		return $this->db->getFirstGrid($sql);
	}
}
?>