<?php

abstract class Database
{
  // Variable
  protected $conn;
  protected $table_name, $columns;
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
  abstract function by_data($fields);
  abstract function insert($fields);
  abstract function update($fields , $id); // id not needed? id in instance
  abstract function delete($id);
  function select_all(){
    $sql = "SELECT * FROM $this->table_name";
    $result = mysqli_query($this->conn,$sql);
    $select_array = [];
    while ($row = mysqli_fetch_array($result)) {
      $fields = [];
      foreach ($row as $key => $value) {
        $fields[$key] = $value;
      }
      $class = get_class($this);
      $temp_class = new $class($fields);
      array_push($select_array,$temp_class);
    }
    return $select_array;
  }
  // $where = "WHERE x = y"
  // function select_where($table_name,$where);
}

class Drink extends Database
{
  private $id, $name, $condiments_ID, $beans,$price,$desc;
  protected $table_name = "drink";
  protected $columns = "name,price,desc";
  function __construct($fields){
    parent::__construct();
    if($fields){
      $this->id = $fields['ID'];
      $this->name = $fields['name'];
      $this->condiments_ID = [];
      // Split IDs and aggregate condiments
      $cond_str = explode(",",$fields['condiments_ID']);
      foreach ($cond_str as $value) {
        $cond = new Condiment(0);
        $cond->by_id(intval($value));
        array_push($this->condiments_ID, $cond);
      }
      $beans_temp = new Beans(0);
      $beans_temp->by_id($fields['beans_ID']);
      $this->beans = $beans_temp;
    }
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
    $this->price = $row['price'];
    $this->desc = $row['description'];
    //$beans_temp = new Beans(0);
    //$beans_temp->by_id($row['beans_ID']);
    //$this->beans = $beans_temp;
    //$this->condiments_ID = [];
    // Split IDs and aggregate condiments
    //$cond_str = explode(",",$row['condiments_ID']);
    /*foreach ($cond_str as $value) {
      $cond = new Condiment(0);
      $cond->by_id(intval($value));
      array_push($this->condiments_ID, $cond);
    }*/
  }

  function by_data($fields){
    $this->name = $fields['name'];
    $this->condiments_ID = $fields['condiments_ID'];
    $this->beans = $fields['beans'];
    $this->id = $this->insert();
  }

  function insert($fields){
    $values = implode("','",array_values($fields));
    $sql = "INSERT INTO $this->table_name($this->columns) VALUES ('$values')";
    $result = mysqli_query($this->conn,$sql);
    return mysqli_insert_id($this->conn);
  }

  function update($fields , $id)
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
    echo "$this->id <br> $this->name <br> $this->price";


  }

  function get_name(){
    return $this->name;
  }

  function get_desc(){
    return $this->desc;
  }

  function get_price(){
    return $this->price;
  }

}

class Condiment extends Database
{
  private $id, $name, $price, $type;
  protected $columns = "name,price,type";
  protected $table_name = "condiment";
  function __construct($fields){
    parent::__construct();
    if ($fields) {
      $this->id = $fields['ID'];
      $this->name = $fields['name'];
      $this->price = $fields['price'];
      $this->type = $fields['type'];
    }
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

  function by_data($fields){
    $this->name = $fields['name'];
    $this->price = $fields['price'];
    $this->type = $fields['type'];
    $this->id = $this->insert();
  }

  function insert($fields){
    $values = implode("','",array_values($fields));
    $sql = "INSERT INTO $this->table_name($this->columns) VALUES ('$values')";
    $result = mysqli_query($this->conn,$sql);
    return mysqli_insert_id($this->conn);
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

  function display(){
    echo "<br> $this->id <br> $this->name <br> $this->price <br> $this->type <br>";
  }

}

class Beans extends Database
{
  private $id, $name, $price;

  //please dont changephp doesnt allow constants oop :(
  protected $columns = "name,price";
  protected $table_name = "beans";
  function __construct($fields){
    parent::__construct();
    if ($fields) {
      $this->id = $fields['ID'];
      $this->name = $fields['name'];
      $this->price = $fields['price'];
    }
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
  function by_data($fields){
    $this->name = $fields['name'];
    $this->price = $fields['price'];
    $this->id = $this->insert();
  }
  function insert($fields){
    $values = implode("','",array_values($fields));
    $sql = "INSERT INTO $this->table_name($this->columns) VALUES ('$values')";
    $result = mysqli_query($this->conn,$sql);
    return mysqli_insert_id($this->conn);

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

// echo "<br>test drink <br> ";
// $class = new Drink(0);
// $class = $class->select_all();
// foreach ($class as $value) {
//   $value->display();
// }
// echo "<br> test beans <br>";
// $class = new Beans(0);
// $class = $class->select_all();
// foreach ($class as $value) {
//   $value->display();
// }
// echo "<br> test condiments <br>";
// $class = new Condiment(0);
// $class = $class->select_all();
// foreach ($class as $value) {
//   $value->display();
// }
?>
