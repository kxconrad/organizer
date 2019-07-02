<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Debug
 *
 * @author konrad
 */
class Debug
{

    public static function dump($element, $label = null)
    {

        echo "<pre>";
        echo "*************************";
        echo "<br/>";
        if ($label) {
            echo $label."<br/>";
        }
        if (is_array($element)) {
            print_r($element);
        } else {
            var_dump($element);
        }
        echo "*************************";
        echo "<br/>";
        echo "</pre>";
    }
}