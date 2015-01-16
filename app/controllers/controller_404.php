<?php

class Controller_404 extends Controller
{
    function action_index(){
        $this->view->setTemplateName('404_view.tpl');
        $this->view->getFinalPage();
    }
}