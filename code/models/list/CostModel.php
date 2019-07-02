<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListModel
 *
 * @author konrad
 */
class CostModel extends Model
{

    public function __construct()
    {
        $this->table  = 'cost';
        $this->id     = 'id';
        $this->fields = array('id', 'month', 'cost', 'description');
    }

}