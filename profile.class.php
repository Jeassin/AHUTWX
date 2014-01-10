<?php
class ahutProfile
{
    private $db;

    public function __construct()
    {
        $this->db = new ahutDB();
    }

    public function getInfo($input)
    {
        if (endsWith($input, '的课表')) {
            $input = substr($input, 0, strpos($input, '的课表'));
            return $this->getStudentLesson($input);
        } else return $this->getStudentInfo($input);
    }

    //查询学生信息
    public function getStudentInfo($input)
    {
        try {
            $data = $this->getStudentRows($input);
            $ret = '';
            if (count($data) == 0) {
                $ret = '神马都没搜到...' . "\n";
            } else if (count($data) == 1) {
                $info = $data[0];
                $ret =  $info['xh'] . ' ' . $info['xm'] . ' ' . $info['xb'] . ' ' . $info['xy'] . ' ' . $info['zy'] . ' ' . $info['bj'];
                $ret .= "\n" . '回复“' . $input . '的课表”试试？';
            } else if (count($data) > 1) {
                if (count($data) > RESULT_MAX) {
                    $data = array_slice($data, 0, RESULT_MAX);
                    $ret = '搜到了一大坨，只显示前' . RESULT_MAX . '个...' . "\n";
                }
                foreach ($data as $info) {
                    $ret .= "{$info['xh']} {$info['xm']} {$info['xb']} {$info['xy']} {$info['bj']}\n";
                }
            }
            return $ret;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getStudentLesson($xh)
    {
        try {
            $data = $this->getStudentRows($xh);
            if (count($data) == 0) {
                return '查无此人...' . "\n";
            } else if (count($data) == 1) {
                return $this->xh2lesson($data[0]['xh']);
            } else if (count($data) > 1) {
                $ret = '';
                if (count($data) > RESULT_MAX) {
                    $data = array_slice($data, 0, RESULT_MAX);
                    $ret = '搜到了一大坨，只显示前' . RESULT_MAX . '个...' . "\n";
                }
                foreach ($data as $info) {
                    $ret .= "{$info['xh']} {$info['xm']} {$info['xb']} {$info['xy']} {$info['bj']}\n";
                }
                return $ret . '请选择一个学号';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function xh2lesson($xh)
    {
        $data = $this->db->getData("SELECT * FROM `" . LESSON_TABLE . "` WHERE xh = '$xh'");
        $ret = '';
        foreach ($data as $info) {
            $week = $GLOBALS['weeks'][$info['week']];
            $time = $GLOBALS['times'][$info['time']];
            $ret .= $info['lessonname'] . '/' . $info['teachername'] . '/' . $week . $time . '/' . $info['startweek'] . '～' . $info['endweek'] . '周/' . $info['place'] . "\n";
            $ret .= TEXT_BANNER;
        }
        return $ret;
    }

    public function getStudentRows($input)
    {
        if (isXH($input)) {
            return $this->db->getData("SELECT * FROM `" . PROFILE_TABLE . "` WHERE xh = '$input'");
        } else if (isXM($input)) {
            return $this->db->getData("SELECT * FROM `" . PROFILE_TABLE . "` WHERE xm LIKE '%$input%'");
        } else if (isBJ($input)) {
            return $this->db->getData("SELECT * FROM `" . PROFILE_TABLE . "` WHERE bj LIKE '%$input%'");
        } else if (isPY($input)) {
            $input = strtoupper($input);
            $py = substr($input, 0, 1);
            $py1 = substr($input, 1, 1);
            $py2 = (strlen($input) == 3) ? substr($input, 2, 1) : 0;
            if (strlen($input) == 2) {
                $sql = "SELECT * FROM `" . PROFILE_TABLE . "` WHERE PY LIKE '$py' AND PY1 LIKE '$py1' AND PY2 is NULL";
            } else {
                $sql = "SELECT * FROM `" . PROFILE_TABLE . "` WHERE PY LIKE '$py' AND PY1 LIKE '$py1' AND PY2 LIKE '$py2'";
            }
            return $this->db->getData($sql);
        } else throw new Exception('请检查输入是否有误' . "\n" . MENU_TIP1);
    }
}