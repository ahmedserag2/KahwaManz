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

  function last_insert()
  {
    $lastId;
    $sql = "SELECT MAX(ID) as last FROM $this->table_name";
    $result = mysqli_query($this->conn,$sql);
    $lastId = mysqli_fetch_array($result);
    $lastId = $lastId['last'];
    return $lastId;
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
  protected $columns = "name,price,description,image";
  function __construct($fields){
    parent::__construct();
    if($fields){
      $this->id = $fields['ID'];
      $this->name = $fields['name'];
      $this->price = $fields['price'];
      $this->desc = $fields['description'];
      $this->condiments_ID = [];
      $this->image = $fields['image'];
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
    $this->image = $row['image'];
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
    // $this->condiments_ID = $fields['condiments_ID'];
    $this->desc = $row['description'];
    $this->image = $fields['image'];
    $this->id = $this->insert();
  }
  function get_image()
  {
    return $this->image;
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

  function display_menu_item(){
    $maxprice = number_format($this->get_price() + 14, 2, '.', '');
    echo
    "<tr onclick='toOrder($this->id)'>
      <td><img class='drink_img' src='..\Images\Drinks\\$this->image' alt='Image not found...'></td>
      <td >
        <span>$this->name<br></span>
        <span class='desc'>$this->desc</span>
        <span>$this->price - $maxprice</span>
      </td>
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

  function get_image(){
    return $this->image;
  }

}

class Condiment extends Database
{
  private $id, $name, $price;
  protected $columns = "name,price";
  protected $table_name = "condiment";
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
    $sql = "SELECT * FROM condiment WHERE ID = $id";
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
  private $id, $name, $price;
  protected $columns = "name,price";
  protected $table_name = "beverages";
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
    $sql = "SELECT * FROM condiment WHERE ID = $id";
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

  function display(){
    echo "<br> $this->id <br> $this->name <br> $this->price <br> $this->type <br>";
  }

  function get_id(){
    return $this->id;
  }

  function get_name(){
    return $this->name;
  }

  function get_price(){
    return $this->price;
  }

  function display_table_row(){

    $values = array("ID"=>$this->id,"name"=>$this->name,"price"=>$this->price,"type"=>$this->type);
    $json_object = json_encode($values);

    echo "<tr>
    <th scope='row'>{$this->id}</th>
    <td>{$this->name}</td>
    <td>{$this->price} EGP</td>
    <td>{$this->type} </td>
    <td>
    <button  type='button' onclick='setEditModal({$json_object})' class='btn btn-warning add' data-toggle='modal' data-target='#editItemModal' >Edit</button>
    <a href='admin_beverages.php?delete={$this->id}'><button  type='button'  class='btn btn-danger'>Delete</button></a>
    </td>


    </tr> ";
  }

}

class User extends Database
{

  private $id, $username,$email,$password,$mobile,$type ;
  protected $table_name = "user";
  //changed desc to description to match column name in db
  protected $columns = "username,email,password,mobile,type";
  function __construct($fields){
    parent::__construct();
    //pass fields null temporarly
    if($fields){

      $this->id = $fields['ID'];
      $this->username = $fields['username'];
      $this->email = $fields['email'];
      $this->password = $fields['password'];

      $this->mobile = $fields['mobile'];
      $this->type = $fields['type'];

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

  }

  function by_data($fields){
    $this->name = $fields['name'];
    $this->condiments_ID = $fields['condiments_ID'];
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
  function display_table_row(){

    $values = array("ID"=>$this->id,"username"=>$this->username,"email"=>$this->email,"password"=>$this->password,"mobile"=>$this->mobile , "type"=>$this->type );
    $json_object = json_encode($values);
    //$this->id = $fields['ID'];

    echo "<tr>
    <th scope='row'>{$this->id}</th>

    <td>{$this->username}</td>
    <td>{$this->email} </td>
    <td>{$this->mobile} </td>

    <td>{$this->type} </td>
    <td>
    <button  type='button' onclick='setEditModal({$json_object})' class='btn btn-warning add' data-toggle='modal' data-target='#editItemModal' >Edit</button>
    <a href='admin_users.php?delete={$this->id}'><button  type='button'  class='btn btn-danger'>Delete</button></a>
    </td>


    </tr> ";
  }

  function get_name(){
    return $this->name;
  }


}


?>
