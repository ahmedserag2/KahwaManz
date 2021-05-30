<?php

abstract class Table
{
  // Variable
  protected $conn;
  // Functions
  function __construct() {
    $this->conn = new mysqli("localhost", "root", "", "coffeeshop");
  }
  function __destruct() {
    $this->conn->close();
  }
  // Abstract Functions
  // $fields->dict. used as placeholder
  abstract function by_id($id);
  // abstract function by_data($fields);
  abstract function insert($fields);
  abstract function update($fields , $id);
  abstract function delete($id);
  // select not needed? by_id constructs
}

class Drink extends Table
{
  private $id, $name, $condiments, $beans;

  function __construct(){
    parent::__construct();
  }
  function __destruct() {
    parent::__destruct();
  }
  function by_id($id){
    $sql = "SELECT * FROM drink WHERE ID = $id";
    $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_array($result);

    $this->id = $row['ID'];
    $this->name = $row['name'];
    $beans_temp = new Beans();
    $beans_temp->by_id($row['ID']);
    $this->beans = $beans_temp;
    $this->condiments = [];
    // Split IDs and aggregate condiments
    $cond_str = explode(",",$row['condiments_ID']);
    foreach ($cond_str as $value) {
      $cond = new Condiment();
      $cond->by_id(intval($value));
      array_push($this->condiments, $cond);
    }
  }

  function insert($feilds){

    return true;
  }

  function update($fields , $id)
  {

  }
  function delete($id)
  {
    $sql = "DELETE FROM $this->table_name WHERE ID = $id";
    $result = mysqli_query($this->conn,$sql);
    return $result;
  }
   //test function
  function display(){
    echo "$this->id <br> $this->name <br> ";
    $this->beans->display();
    foreach ($this->condiments as $value) {
      $value->display();
    }
  }

}

class Condiment extends Table
{
  private $id, $name, $price, $type;

  function __construct(){
    parent::__construct();
  }
  function __destruct() {
    parent::__destruct();
  }
  function by_id($id){
    $sql = "SELECT * FROM condiment WHERE ID = $id";
    $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_array($result);
    $this->id = $row['ID'];
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->type = $row['type'];
  }
  function insert($fields){
    return true;
  }

  function update($fields , $id){

  }
  function delete($id)
  {
    $sql = "DELETE FROM $this->table_name WHERE ID = $id";
    $result = mysqli_query($this->conn,$sql);
    return $result;
  }

  function display(){
    echo "<br> $this->id <br> $this->name <br> $this->price <br> $this->type <br>";
  }

}

class Beans extends Table
{
  private $id, $name, $price;

  //please dont changephp doesnt allow constants oop :(
  private $columns = "name,price";
  private $table_name = "beans";
  function __construct(){
    parent::__construct();
  }
  function __destruct() {
    parent::__destruct();
  }
  function by_id($id){
    $sql = "SELECT * FROM beans WHERE ID = $id";
    $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_array($result);
    $this->id = $row['ID'];
    $this->name = $row['name'];
    $this->price = $row['price'];
  }
  function insert($fields){
    $values = implode("','",array_values($fields));
    $sql = "INSERT INTO $this->table_name($this->columns) VALUES ('$values')";
    $result = mysqli_query($this->conn,$sql);
    return $result;

  }

  function update($fields, $id)
  {
    $columns = explode(",",$this->columns);
    $noOfElements = count($fields);
    $updatedElements = "";
    //constructing the query
    for($i = 0; $i < $noOfElements; $i++)
    {
      // set up the term columnname = value ,
      $updatedElements .= "`{$columns[$i]}`" ." = ". "'{$fields[$i]}'";
      //dont add the comma if its last element
      if($i != $noOfElements - 1)
      {
        $updatedElements .= " , ";
      }
    }
    //check the id to update 
    $sql = "UPDATE $this->table_name SET " . $updatedElements . " WHERE ID = $id";
    $result = mysqli_query($this->conn,$sql);
    return $result;
  }

  function delete($id)
  {
    $sql = "DELETE FROM $this->table_name WHERE ID = $id";
    $result = mysqli_query($this->conn,$sql);
    return $result;
  }
  //test function
  function display(){
    echo "<br> $this->id <br> $this->name <br> $this->price <br>";
  }
}


?>
