<?php

class Autoloader{

    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class_name){
        require 'models/class/' . ucfirst($class_name) . '.php';
    }

    static function registerChecks(){
        spl_autoload_register(array(__CLASS__, 'autoloadChecks'));
    }

    static function autoloadChecks($class_name){
        require '../models/class/' . ucfirst($class_name) . '.php';
    }
}
