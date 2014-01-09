<?
class ahutDB
{
	private $conn;
	
	public function __construct()
	{
		$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
		mysql_set_charset('utf8', $con); 
		mysql_select_db(SAE_MYSQL_DB, $con);
		if(!$con) {
			throw new Exception('数据库无法连接' . mysql_error());
		}
	}
	
	public function getData($sql)
	{
		$result = array();
		$r = mysql_query($sql);
		if($r === false) return $result;
		for($i=0;$i<mysql_num_rows($r);$i++){
			$result[$i] = mysql_fetch_array($r);
		}
		return $result;
	}
	
	public function getFirstRow($sql)
	{
		$data = $this->getData($sql);
		return $data[0];
	}
	
	public function getFirstGrid($sql)
	{
		$data =  $this->getData($sql);
		return $data[0][0];
	}
	public function getCount($sql)
	{//have problem
		$data = mysql_query($sql);
		return mysql_num_rows($data);
	}
	public function runSql($sql)
	{
		return mysql_query($sql);
	}

}

?>