<?php include 'classes.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="../master.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      table{
        font-size: 50px;
        width: 99%;
        border-collapse: collapse;
      }
      tr{
        border-bottom: 4px solid darkgrey;
        cursor: pointer;
        text
      }
      .drink_img{
        max-width: 300px;
        height: auto;
        border-radius: 40px;
      }
      .desc{
        color: #4D4D4D;
        font-size: 40px;
      }
      .add{
        background-color: #954B00;
        border-color: #954B00;
        border-radius: 8px;
        padding: 6px;
      }
      input[type="text"]{
        font-family: "Roboto";
        padding-left: 95px;
        font-size: 50px;
        margin: 0;
        position: absolute;
        bottom: 96%;
        left: 15%;
        width: 60%;
        height: 100px;
        box-shadow: 0px 6px grey;
        z-index:10;
        border: none;
        border-radius: 50px;
      }
      .custom{
        font-size: 45px;;
        position: relative;
        left: 27%;
        color: #954B00;
      }
    </style>
    <script src="../js/clamp.min.js"></script>
    <script type="text/javascript">
      function toOrder(id){
        window.location="OrderDetails.php?id="+id;
      }
      function overflow(){
        var desc = document.getElementsByClassName("desc");
        for (var i = 0; i < desc.length; i++) {
          $clamp(desc[i], {clamp: 2});
        }
      }


    </script>
  </head>
  <body onload="overflow()">
    <div class="container">
      <div class="bg">
        <img src="../images/images.jpg" alt="">
      </div>
    </div>

    <div class="menu-bg-c">
      <input type="text" name="" placeholder="  Search..."><br><br><br><br><br>
      <a class="cart" href="basket.php" ><i class="fas fa-shopping-cart"></i></a> <br><br>
        <a class="custom" href="customize.php" >Customise your drink</a> <br><br>

      <table>
      <?php
        include_once 'classes.php';
        $drinks = new Drink(0);
        $drinks = $drinks->select_all();
        foreach ($drinks as $drink) {
          $drink->display_menu_item();
        }
      ?>
      </table>
    </div>


  </body>
</html>
