<?php
  include_once 'classes.php';
  $drinks = new Drink(0);
  if(isset($_POST['bar'])){
    $drinks = $drinks->select_all($_POST['bar']);
  }
  else {
    $drinks = $drinks->select_all();
  }
  foreach ($drinks as $drink) {
    $drink->display_menu_item();
  }
?>
