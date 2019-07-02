<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author konrad
 */
class Controller
{

    public function view($templateFile, $vars = array())
    {
        ob_start();
        extract($vars, EXTR_OVERWRITE);
        require($templateFile);

        echo ob_get_clean();
    }
}