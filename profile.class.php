<?
class ahutProfile
{
	//查询用户信息
	public function getStudentInfo($input)
	{
		$table = 'baseprofile2013';
		$db = new ahutDB();
		if ($this->checkXH($input)){
			$info = $db->getFirstRow("SELECT * FROM `$table` WHERE xh = '$input'");
			return $info['xm'].' '.$info['xb'].' '.$info['xy'].' '.$info['zy'].' '.$info['bj'];
		} else if (preg_match('/^[\x80-\xff]{6,12}$/', $input)) {
			$sql = "SELECT * FROM `$table` WHERE xm LIKE '%$input%'";
			$data = $db->getData($sql);
			if (count($data) == 1) {
				$info = $data[0];
				return $info['xh'].' '.$info['xm'].' '.$info['xb'].' '.$info['xy'].' '.$info['zy'].' '.$info['bj'];
			} else if (count($data) > 1) {
				$ret = '';
				foreach ($data as $info) {
					$ret .= "{$info['xh']} {$info['xm']} {$info['xb']} {$info['xy']} {$info['bj']}\n";
				}
				return $ret;
			}
		}
/* 		else if(preg_match('/^[A-Z]{2,3}$/',$input)){
			$py = substr($input, 0, 1);
			$py1 = substr($input, 1, 1);
			$py2 = (strlen($input)==3) ? substr($input, 2, 1) : 0;
			if (strlen($input) == 2) {
				$sql = "SELECT * FROM `profilepy` WHERE PY LIKE '$py' AND PY1 LIKE '$py1' AND PY2 is NULL";
			}else{
				$sql = "SELECT * FROM `profilepy` WHERE PY LIKE '$py' AND PY1 LIKE '$py1' AND PY2 LIKE '$py2'";
			}
		}  */
		else {
			return '请检查输入是否有误';
		}
	}
	
	//检查学号是否有效
	public function checkXH($xh)
	{
		return preg_match('/^[0-9]{9}$/',$xh);
	}
}

?>