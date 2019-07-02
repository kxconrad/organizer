<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Routing
 *
 * @author konrad
 */
class Base
{

    function initialize()
    {

        $this->setErrors();
        $this->addFiles();
        $this->handleRouting();
    }

    function setErrors()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    function addFiles()
    {
        require_once 'code/controllers/Controller.php';

        require_once 'code/models/Model.php';

        require_once 'code/helpers/ElementLoader.php';
        require_once 'code/helpers/Debug.php';

        require_once 'code/models/list/CostModel.php';
        require_once 'code/models/list/BudgetModel.php';

        require_once 'code/services/list/ListItemService.php';
    }

    function handleRouting()
    {



        $controller = '';
        $action     = '';
        $parameter  = '';
        $url        = explode("/", $_SERVER['REQUEST_URI']);



        if (!empty($url[2])) {
            $controller     = ucfirst($url[2])."Controller";
            $controllerPath = "code/controllers/".ucfirst($url[2])."Controller.php";

            if (!empty($url[3])) {
                $action = explode('-', $url[3]);
                if (count($action) > 1) {
                    $action[1] = ucfirst($action[1]);
                    $action    = implode('', $action);
                } else {
                    $action = implode('', $action);
                }
                $action .= "Action";

//
//            echo "controller: ".$controller."<br/>";
//            echo "controller path: ".$controllerPath."<br/>";
//            echo "action: ".$action."<br/>";
//            echo "parameter: ".$parameter."<br/>";


                if (!is_file($controllerPath)) {
                    echo 'controller: '.$controllerPath.' not found!';
                    die();
                }

                require $controllerPath;

                if (!class_exists($controller, false)) {
                    echo 'class: '.$controller.' not found!';
                    die();
                }


                $class = new $controller;

                if (!method_exists($class, $action)) {
                    echo 'action: '.$action.' in controller: '.$class.'  not found!';
                    die();
                }
                $class->$action();
                die();
            }
        }
    }
}
$base = new Base();
$base->initialize();
