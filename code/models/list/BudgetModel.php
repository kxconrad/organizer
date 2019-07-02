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
class BudgetModel extends Model
{

    public function __construct()
    {
        $this->table  = 'month_budget';
        $this->fields = array('month_id', 'budget');
        $this->id = 'month_id';
    }
}