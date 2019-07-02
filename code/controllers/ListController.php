<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListController
 *
 * @author konrad
 */
class ListController extends Controller
{

    public function __construct()
    {
        $this->listService = new ListItemService();
    }

    public function editAction()
    {
        $data = $this->listService->getNeccessaryValues();
//        Debug::dump($data);
        return $this->view('code/templates/singleListElement.php',
                array('data' => $data));
    }

    public function editCostAction()
    {
//        echo "running edit cost action";
        $data = $this->listService->getNeccessaryValues();
        $data = $this->listService->getCostData($data);
//        Debug::dump($data);
        return $this->view('code/templates/singleListElement.php',
                array('data' => $data));
    }

    public function updateAction()
    {

        $this->listService->update();

        return $this->editAction();
    }

    public function removeAction()
    {
        $this->listService->remove();

        return $this->editAction();
    }

    public function indexAction()
    {
        return $this->view('code/templates/list.php');
    }
}