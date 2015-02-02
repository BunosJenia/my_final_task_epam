<?php

class View
{
    private $template;
    private $template_name;
    private $placeholders = array();
    private $labels = array();
    public $config_object;

    public function __construct(){
        $this->config_object = new Config();
        $this->setLabels($this->config_object->getAllLabels());
    }

    public function getConfig(){
        return $this->config_object;
    }

    public function setMainTemplate($main_template_filename){
        if (!is_file($main_template_filename)) {
            throw new Exception('Main template ['.$main_template_filename.'] not found.');
        }
        $this->template = file_get_contents($main_template_filename);
    }

    public function setPlaceholderDirect($name, $value){
        $this->template = str_replace($name, $value, $this->template);
    }

    public function setPlaceholder($name, $value){
        $this->placeholders[$name] = $value;
    }

    public function setLabels($labels_array){
        $this->labels = $labels_array;
    }

    public function setTemplateName($template_name){
        $this->template_name = $template_name;
    }

    private function processDV($dv){
        $placeholder_name = $dv[1];
        if(isset($this->placeholders[$placeholder_name])){
            return $this->placeholders[$placeholder_name];
        }
        else
        {
            throw new Exception('Placeholder ['.$placeholder_name.'] not found.');
        }
    }

    private function processLabels($lb){
        $label_name = $lb[1];
        if (isset($this->labels[$label_name])){
            return $this->labels[$label_name];
        }
        else{
            throw new Exception('Label ['.$label_name.'] not found.');
        }
    }

    // Под подключаем нашу вьюшку
    private function processSubtemplatesView(){
        if(isset($this->template_name)){
            $subtemplate_name = $_SERVER["DOCUMENT_ROOT"].'/app/views/'.$this->template_name;
            if (is_file($subtemplate_name)){
                return file_get_contents($subtemplate_name);
            }
            else{
                throw new Exception('Subtemplate ['.$subtemplate_name.'] not found.');
            }
        }
    }

    // Тут подключаем различные блоки
    private function processSubtemplates($tn){
        $subtemplate_name = $_SERVER["DOCUMENT_ROOT"].'/app/views/templates/'.$tn[1];
        if (is_file($subtemplate_name)){
            return file_get_contents($subtemplate_name);
        }
        else
        {
            throw new Exception('Subtemplate ['.$subtemplate_name.'] not found.');
        }
    }

    public function processTemplate()
    {
        while (preg_match("/{FILE=\"(.*)\"}|{DV=\"(.*)\"}|{LABEL=\"(.*)\"}/Ui", $this->template)){
            $this->template = preg_replace_callback("/{DV=\"(.*)\"}/Ui", array($this, 'processDV'), $this->template);
            $this->template = preg_replace_callback("/{LABEL=\"(.*)\"}/Ui", array($this, 'processLabels'), $this->template);
            $this->template = preg_replace_callback("/{FILE=\"file\"}/Ui", array($this, 'processSubtemplatesView'), $this->template);
            $this->template = preg_replace_callback("/{FILE=\"(.*)\"}/Ui", array($this, 'processSubtemplates'), $this->template);
        }
        $this->template;
    }

    public function getFinalPage($remove_comments = TRUE, $compress = TRUE){
        $this->processTemplate();
        $temp = $this->template;
        if ($remove_comments){
            $temp = preg_replace("/<!--.*-->/sU", "", $temp);
        }

        if ($compress){
            while (strpos($temp, '  ')!==FALSE){
                $temp = str_replace('  ', ' ', $temp);
            }

            while (strpos($temp, "\r\r")!==FALSE){
                $temp = str_replace("\r\r", "\r", $temp);
            }

            while (strpos($temp, "\n\n")!==FALSE){
                $temp = str_replace("\n\n", "\n", $temp);
            }

            while (strpos($temp, "\r\n\r\n")!==FALSE){
                $temp = str_replace("\r\n\r\n", "\r\n", $temp);
            }

        }

        echo $temp;
    }

}