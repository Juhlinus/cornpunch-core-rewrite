<?php

use Cornpunch\AjaxController;

//Create a new class
if( $_POST ){
    $ajax = new AjaxController;
    if( $_POST["action"]){
        echo json_encode($ajax->parseAction($_POST["action"], $_POST));
    }
}