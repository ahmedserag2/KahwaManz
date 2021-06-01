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
  function select_all($key = null){
    if(isset($key))
    {
      $sql = "SELECT * FROM $this->table_name WHERE name like '%$key%'";
    }
    else{
      $sql = "SELECT * FROM $this->table_name";
    }
    
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


  function select_pagiated($pageNo , $itemsNo, $key = null){
    $limit = $itemsNo;
    $offset = $pageNo * $itemsNo;
    if(isset($key)){
      $sql = "SELECT * FROM $this->table_name WHERE name like '%$key%' LIMIT $limit OFFSET $offset";
    }
    else{
      $sql = "SELECT * FROM $this->table_name LIMIT $limit OFFSET $offset";
    }
    
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
  private $id, $name, $condiments_ID, $beans,$price,$desc,$image;
  protected $table_name = "drink";
  //changed desc to description to match column name in db
  protected $columns = "name,price,description";
  function __construct($fields){
    parent::__construct();
    if($fields){
      $this->id = $fields['ID'];
      $this->name = $fields['name'];
      $this->price = $fields['price'];
      $this->desc = $fields['description'];
      $this->condiments_ID = [];
      $this->image = "";
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
    echo $sql;
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
  function display_menu_item(){
    echo
    "<tr>
    <td><img style='max-width:150px; max-height:150px;' src='..\Images\menu.jpg' alt='Image not found...'></td>

    <td style='width:75%'>
    $this->name<br>
    <span style='color:darkgrey'>$this->desc</span><br>
    $this->price
    </td>

    <td> <button class='add' type='button' name='button'><img src='..\Images\plus-16 (1).png' alt='Image not found...'></button> </td>
    </tr>";
  }
  function display_table_row(){

    $values = array("ID"=>$this->id,"name"=>$this->name,"price"=>$this->price,"description"=>$this->desc);
    $json_object = json_encode($values);

    echo "<tr>
    <th scope='row'>{$this->id}</th>
    <td>{$this->name}</td>
    <td>{$this->price} EGP</td>
    <td>{$this->desc} </td>
    <td>
    <button  type='button' onclick='setEditModal({$json_object})' class='btn btn-warning add' data-toggle='modal' data-target='#editItemModal' >Edit</button>
    <a href='admin_drinks.php?delete={$this->id}'><button  type='button'  class='btn btn-danger'>Delete</button></a>
    </td>


    </tr> ";
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

  function get_id(){
    return $this->id;
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

class Beverage extends Database
{
  private $id, $name, $price, $type;
  protected $columns = "name,price,type";
  protected $table_name = "beverages";
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

  function get_id(){
    return $this->id;
  }

  function get_name(){
    return $this->name;
  }

  function get_type(){
    return $this->type;
  }

  function get_price(){
    return $this->price;
  }

}

?>
