<?php
class ahutFood
{
    private $db;

    public function __construct()
    {
        $this->db = new ahutDB();
    }

    public function nextFood()
    {
        $period = getTimePeriod();
        $sql = 'SELECT * FROM `wx_food` WHERE ' . $period . ' = 1 ORDER BY RAND() LIMIT 1';
        $food = $this->db->getFirstRow($sql);
        return '去' . $food['place'] . '吃' . $food['food']. '！'. "\n";
    }
}