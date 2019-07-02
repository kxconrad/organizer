<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListItemService
 *
 * @author konrad
 */
class ListItemService
{

    /**
     * Get model data and make calculations
     * @return array
     */
    public function getNeccessaryValues()
    {
        $data        = new stdClass();
        $costModel   = new CostModel();
        $budgetModel = new BudgetModel();


        $data->month     = $_POST['month'];
        $data->date      = $_POST['date'];
        $data->costModel = $costModel->getAllByColumn('month', $data->month);
        $data->budget    = $budgetModel->getColumnByColumn('budget', 'month_id',
            $data->month);


        $data->monthCosts = 0;
        foreach ($data->costModel as $costKey => $costValue) {

            $data->monthCosts += $costValue['cost'];
        }

        $data->actualBudget = $data->budget - $data->monthCosts;

//        Debug::dump($data);

        return $data;
    }

    public function getCostData($data)
    {

        $costModel      = new CostModel();
        $data->editCost = $costModel->getById($_POST['cost_id']);

        return $data;
    }

    public function update()
    {

        $costModel   = new CostModel();
        $budgetModel = new BudgetModel();

        $budgetModel->update($_POST['month']);

        $costModel->update($_POST['cost_id']);

//        Debug::dump($_POST);
//        Debug::dump($costModel);
    }

    public function remove()
    {
        $costModel = new CostModel();
        $costModel->delete($_POST['cost_id']);
    }
}