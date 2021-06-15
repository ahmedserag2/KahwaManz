<!DOCTYPE html>
<?php
include 'classes.php';
session_start();
if (!isset($_SESSION['drinks_basket'])) {
  $_SESSION['drinks_basket']=array();
}
$drink = new Drink(null);
$drink->by_id($_GET['id']);
$photo= $drink->get_image();
$photopath="../Images/Drinks/$photo";
 ?>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="../master.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="container">
      <div class="bg">
        <img src="<?php echo $photopath ?>" alt="">
      </div>
    </div>
    <?php
    if (isset($_POST['submit']) && !empty($_POST['submit']))
    {
      $name = $drink->get_name();
      $sizeprice = number_format($_POST['size'],2, '.', '');
      $quantity = number_format($_POST['quantity'],2, '.', '');
      $sizename = "small";
      if($_POST['size'] == $drink->get_price() + 6){
        $sizename = "Medium";
      }
      else if($_POST['size'] == $drink->get_price() + 14){
          $sizename = "Large";
      }
      else {
        $sizename = "Small";
      }
      $array = array($name,$sizename, $sizeprice, $quantity,$photopath);
      array_push($_SESSION['drinks_basket'],$array);
      header('Location: menu.php');
    }

     ?>
    <div class="container">
      <div class="menu-bg">
        <a href="menu.php" class="back"><i class="fas fa-arrow-left fa-4x"></i></a>
        <h1><?php echo $drink->get_name(); ?></h1>
        <h2>Description</h2>
        <p><?php echo $drink->get_desc(); ?></p>
        <form class="" action="" method="post">
          <h2>Select Size</h2>
          <input class="radio active" type="radio" id="small" name="size" value="<?php echo $drink->get_price();?>" checked>
          <label class="label" for="small">S (<?php echo $drink->get_price();?>)</label>
          <input class="radio" type="radio" id="medium" name="size" value="<?php echo number_format($drink->get_price() + 6, 2, '.', '');?>">
          <label class="label" for="medium">M (<?php echo number_format($drink->get_price() + 6, 2, '.', '');?>)</label>
          <input class="radio" type="radio" id="large" name="size" value="<?php echo number_format($drink->get_price() + 14, 2, '.', '');?>">
          <label class="label" for="large">L (<?php echo number_format($drink->get_price() + 14, 2, '.', '');?>)</label>
          <h2 style="margin-top: 40px;">Quantity</h2>
          <button class="btn" data-quantity="minus" data-field="quantity" ><i class="fas fa-minus"></i></button>
          <input id="quantity" type="number" name="quantity" value="1">
          <button class="btn" data-quantity="plus" data-field="quantity"><i class="fas fa-plus"></i></button>
          <h2 style="margin-top: 60px; font-size: 50px;">Price</h2>
          <p style="font-size: 60px; font-weight: bold;"><?php echo $drink->get_price()?> - <?php echo number_format($drink->get_price() + 14, 2, '.', '');?></p>
          <input type="submit" class="basket" id="result" name="submit" value="Add to Basket <?php echo $drink->get_price();?>EGP">
        </form>

      </div>
    </div>

  </body>
  <script type="text/javascript">
  $(document).ready(function(){
    var ele = document.getElementsByName('size');
    var sizeprice = 36.00;
    var newval;
    var currentVal = parseInt($('input[name=quantity').val());

    //radio button for Size
    $("input[class^='radio']").click(function() {
      console.log($("input[name='size']:checked").val());
      sizeprice= $(this).val();
      $('input[name=quantity]').val(1);
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
      $("input[id^='result']").val("Add to Basket " + (sizeprice * currentVal) + ".00EGP");
    });


      //increment quantity when pressing the plus sign
      $('[data-quantity="plus"]').click(function(e){
          e.preventDefault();
          fieldName = $(this).attr('data-field');
          var currentVal = parseInt($('input[name='+fieldName+']').val());
          if (!isNaN(currentVal)) {
              $('input[name='+fieldName+']').val(++currentVal);
              newprice= sizeprice * currentVal;
              $("input[id^='result']").val("Add to Basket " + (sizeprice * currentVal) + ".00EGP");
          } else {
              $('input[name='+fieldName+']').val(1);
          }
      });
      //increment quantity when pressing the minus sign
      $('[data-quantity="minus"]').click(function(e) {
          e.preventDefault();
          fieldName = $(this).attr('data-field');
          var currentVal = parseInt($('input[name='+fieldName+']').val());
          if (!isNaN(currentVal) && currentVal > 1) {
              $('input[name='+fieldName+']').val(currentVal - 1);
              $("input[id^='result']").val("Add to Basket " + ((currentVal * sizeprice) - sizeprice) + ".00EGP");
          } else {
              $('input[name='+fieldName+']').val(1);
          }
      });
  });
<?php echo hi ?>

  </script>
</html>
