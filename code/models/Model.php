<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author konrad
 */
class Model
{
    var $host   = 'localhost';
    var $db     = 'organizer';
    var $login  = 'root';
    var $pass   = 'root123';
    var $table  = '';
    var $fields = '';
    var $id     = '';
    var $conn   = null;
    var $model  = null;
    var $query  = '';

    public function __construct()
    {
        $this->prepareConnection();
    }

    public function __get($n)
    {
        echo "traing to get: ".$n." <br/>";
        return "traing to get: ".$n." <br/>";
    }

    public function __set($name, $value)
    {
        echo "traing to set: ".$value." <br/> to: $name "."<br/>";
        $this->$name = $value;
        return "traing to set: ".$value." <br/> to: $name "."<br/>";
    }

    function prepareConnection()
    {
        if (!$this->conn) {
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db",
                    $this->login, $this->pass);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error: ".$e->getMessage();
            }
        }
    }

    function getConnection()
    {
        if (!$this->conn) {
            $this->prepareConnection();
        }
        return $this->conn;
    }

    function insert($data)
    {

        $conn = $this->getConnection();
    }

    function checkIfExists($id)
    {

        $conn        = $this->getConnection();
        $this->query = $this->qSelect().$this->qAllItems().$this->qFrom().$this->table.' '.$this->qWhere().$this->id.$this->qResult().'?';
        $stmt        = $conn->prepare($this->query);
        $stmt->execute(array($id));
        $row         = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return false;
        }
        return true;
    }

    function update($id)
    {
        $conn = $this->getConnection();

        if (!$this->checkIfExists($id)) {
            $this->save();
            return;
        }

        $this->query = ($this->qUpdate().$this->table.' '.$this->qSet());
        $columnQuery = '';
        $values      = array();

//        Debug::dump($this->fields, "fields");
//        Debug::dump($_POST, "POST");

        foreach ($this->fields as $fieldKey => $fieldValue) {

            if (array_key_exists($fieldValue, $_POST)) {
                $columnQuery         = $columnQuery.$fieldValue.'=:'.$fieldValue.',';
                $values[$fieldValue] = $_POST[$fieldValue];
            }
        }

        $values[$this->id] = $id;

        $columnQuery = substr($columnQuery, 0, -1);

        $this->query = $this->query.$columnQuery;

        $this->query = ($this->query.' '.$this->qWhereColumn($this->id).$this->qResult().':'.$this->id);

//        Debug::dump($this->query, '$this->query');
//        Debug::dump($values, '$values');

        $stmt = $conn->prepare($this->query);

        $stmt->execute($values);
    }

    function save($id = null)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qInsert().$this->table.' ');

        $columnQuery = '';
        $valuesQuery = '';

        $values = array();

//        Debug::dump($this->fields, "fields");
//        Debug::dump($_POST, "POST");

        foreach ($this->fields as $fieldKey => $fieldValue) {

            if (array_key_exists($fieldValue, $_POST)) {

                $columnQuery = $columnQuery.$fieldValue.',';

                $valuesQuery = $valuesQuery.':'.$fieldValue.', ';

                $values[$fieldValue] = $_POST[$fieldValue];
            }
        }

        foreach ($values as $valueKey => $value) {

            if ($value == "") {
                return;
            }
        }

        $columnQuery = substr($columnQuery, 0, -1);

        $valuesQuery = substr($valuesQuery, 0, -2);

        $this->query = $this->query.'('.$columnQuery.')'.' '.$this->qValues().'('.$valuesQuery.')';

//        Debug::dump($this->query, '$this->query');
//        Debug::dump($values, '$values');

        $stmt = $conn->prepare($this->query);
//
        $stmt->execute($values);
    }

    function delete($id)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qDelete().$this->qFrom().$this->table.' '.$this->qWhere().$this->id.$this->qResult().':'.$this->id);
        Debug::dump($this->query);
        $stmt        = $conn->prepare($this->query);
        $stmt->execute(array($this->id => $id));
    }

    /**
     * Select all rows from table
     * @return object
     */
    function getAll()
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qSelect().$this->qAllItems().$this->qFrom().$this->table);
//        Debug::dump($this->query);
        $stmt        = $conn->query($this->query)->fetchAll(PDO::FETCH_ASSOC);
        $this->model = $stmt;
//        Debug::dump($this->model);
        return $this->model;
    }

    /**
     * Select all rows for specific id from table
     * @return object
     */
    function getAllById($id)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qSelect().$this->qAllItems().$this->qFrom().$this->table.' '.$this->qWhereColumn('id').$this->qResult().$id);
//        Debug::dump($this->query);
        $stmt        = $conn->query($this->query)->fetchAll(PDO::FETCH_ASSOC);
        $this->model = $stmt;
//        Debug::dump($this->model);
        return $this->model;
    }

    /**
     * Select all rows from table by specific column and his value
     * @param $column - string
     * @param $value - mixed
     * @return object
     */
    function getAllByColumn($column, $value)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qSelect().$this->qAllItems().$this->qFrom().$this->table.' '.$this->qWhereColumn($column).$this->qResult().$value);
//        Debug::dump($this->query);
        $stmt        = $conn->query($this->query)->fetchAll(PDO::FETCH_ASSOC);
        $this->model = $stmt;
//        Debug::dump($this->model);
        return $this->model;
    }

    /**
     * Select row from table by id
     * @param id - int
     * @return object
     */
    function getById($id)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qSelect().$this->qAllItems().$this->qFrom().$this->table.' '.$this->qWhereColumn('id').$this->qResult().$id);
//        Debug::dump($this->query);
        $stmt        = $conn->query($this->query)->fetch(PDO::FETCH_ASSOC);
        $this->model = $stmt;

        return $this->model;
    }

    /**
     * Select row from table by specific column and his value
     * @param $column - string
     * @param $value - mixed
     * @return object
     */
    function getByColumn($column, $value)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qSelect().$this->qAllItems().$this->qFrom().$this->table.' '.$this->qWhereColumn($column).$this->qResult().$value);
//        Debug::dump($this->query);
        $stmt        = $conn->query($this->query)->fetch(PDO::FETCH_ASSOC);
        $this->model = $stmt;

        return $this->model;
    }

    /**
     * Select specific column from table by specific column and his value
     * @param string $selectColumn
     * @param string $whereColumn
     * @param mixed $value
     * @return object
     */
    function getColumnByColumn($selectColumn, $whereColumn, $value)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qSelect().$this->qColumn($selectColumn).$this->qFrom().$this->table.' '.$this->qWhereColumn($whereColumn).$this->qResult().$value);
//        Debug::dump($this->query);
        $stmt        = $conn->query($this->query)->fetch(PDO::FETCH_OBJ);
        $this->model = $stmt;
//        Debug::dump("getColumnByColumn: ", $this->query);
        if ($this->model) {
            return $this->model->$selectColumn;
        }
        return null;
    }

    /**
     * Get all rows with left join
     * @param array $specification
     * $specification['table'] - outer table to join
     * $specification['innerField'] - this table column
     * $specification['outerField'] - outer table column
     * * $specification['outerColumns'] - array of  outer table columns
     * @return object
     */
    function getWithleftJoinAll(array $specification)
    {
        $conn        = $this->getConnection();
        $this->query = ($this->qLeftJoinAll($specification));
        Debug::dump($this->query);
        $stmt        = $conn->query($this->query)->fetchAll(PDO::FETCH_ASSOC);
        $this->model = $stmt;

        return $this->model;
    }

    // ------------- query construct methods -------------

    private function qSelect()
    {

        return 'SELECT ';
    }

    private function qUpdate()
    {

        return 'UPDATE ';
    }

    private function qDelete()
    {

        return 'DELETE ';
    }

    private function qSet()
    {

        return 'SET ';
    }

    private function qAllItems()
    {
        return '* ';
    }

    private function qColumn($column)
    {
        return $column.' ';
    }

    private function qFrom()
    {
        return 'FROM ';
    }

    private function qWhere()
    {
        return 'WHERE ';
    }

    private function qWhereColumn($column)
    {
        return 'WHERE '.$column.' ';
    }

    private function qResult()
    {
        return '= ';
    }

    private function qInsert()
    {
        return 'INSERT INTO ';
    }

    private function qValues()
    {
        return 'VALUES ';
    }

    private function qLeftJoinAll(array $specification)
    {
        $queryString = 'SELECT ';

        $query1 = array();

        foreach ($this->fields as $fieldName) {

            array_push($query1, $this->table.'.'.$fieldName);
        }

        $query2 = array();

        foreach ($specification['outerColumns'] as $outerColumn) {

            array_push($query2, $specification['table'].'.'.$outerColumn);
        }


        $queryString .= implode(',', $query1).', '.implode(',', $query2).' FROM '.$this->table.' LEFT JOIN '.$specification['table'].' ON '.$this->table.'.'.$specification['innerField'].' = '.$specification['table'].'.'.$specification['outerField'];

        return $queryString;
    }
}