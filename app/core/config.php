<?php

class Config
{
    private $config = array();
    private $message = array();
    private $label = array();

    public function __construct(){
        $DB = DB::getInstance();
        $r = $DB->executeQuery("SELECT * FROM `config`");
        while ($row = $r['stmt']->fetch(PDO::FETCH_ASSOC)) {
            $this->config[$row['c_name']] = $row['c_value'];
        }
        $r = $DB->executeQuery("SELECT * FROM `message`");
        while ($row = $r['stmt']->fetch(PDO::FETCH_ASSOC)) {
            $this->message[$row['m_name']] = $row['m_value'];
        }
        $r = $DB->executeQuery("SELECT * FROM `label`");
        while ($row = $r['stmt']->fetch(PDO::FETCH_ASSOC)) {
            $this->label[$row['l_name']] = $row['l_value'];
        }
    }

    public function getMessageById($id){
        if (isset($this->message[$id])){
            return $this->message[$id];
        }
        else{
            throw new Exception('Broken config. Message ['.$id.'] is missing.');
        }
    }

    public function getParameterById($id){
        if(isset($this->config[$id])){
            return $this->config[$id];
        }
        else{
            throw new Exception('Broken config. Parameter ['.$id.'] is missing.');
        }
    }

    public function getLabelById($id){
        if(isset($this->label[$id])) {
            return $this->label[$id];
        }
        else{
            throw new Exception('Broken config. Label ['.$id.'] is missing.');
        }
    }

    public function getAllLabels(){
        return $this->label;
    }

}
