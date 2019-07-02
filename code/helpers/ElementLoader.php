<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Generator
 *
 * @author konrad
 */
class ElementLoader
{
    const MONTH_LIST = 'code/templates/list.php';
    const HEADER = 'code/templates/header.php';

    public static function insertElement($element)
    {
        require $element;
    }
}