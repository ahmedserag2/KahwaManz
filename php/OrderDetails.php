<!DOCTYPE html>
<?php
include 'classes.php';

$drink = new Drink(null);

$drink->by_id($_GET['id']);
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
        <img src="../Images/images.jpg" alt="">
      </div>
    </div>

    <div class="container">
      <div class="menu-bg">
        <a href="Homepage.php"><img src="../Images/left-arrow.png" alt="" width="60" height="60"></a>
        <h1><?php echo $drink->get_name(); ?></h1>
        <h2>Description</h2>
        <p><?php echo $drink->get_desc(); ?></p>
        <form class="" action="" method="post">
          <h2>Select Size</h2>
          <input id="radio" type="radio" id="small" name="size" value="36.00">
          <label id="label" for="small">S (<?php echo $drink->get_price();?>)</label>
          <input id="radio" type="radio" id="medium" name="size" value="42.00">
          <label id="label" for="medium">M (<?php echo number_format($drink->get_price() + 6, 2, '.', '');?>)</label>
          <input id="radio" type="radio" id="large" name="size" value="50.00">
          <label id="label" for="large">L (<?php echo number_format($drink->get_price() + 14, 2, '.', '');?>)</label>
          <h2 style="margin-top: 40px;">Quantity</h2>
          <button class="btn" data-quantity="minus" data-field="quantity" ><i class="fas fa-minus"></i></button>
          <input id="quantity" type="number" name="quantity" value="1">
          <button class="btn" data-quantity="plus" data-field="quantity"><i class="fas fa-plus"></i></button>
          <h2 style="margin-top: 60px; font-size: 50px;">Price</h2>
          <p style="font-size: 60px; font-weight: bold;"><?php echo $drink->get_price()?> - <?php echo number_format($drink->get_price() + 14, 2, '.', '');?></p>
          <button class="basket" id="result">Add to Basket <?php echo $drink->get_price();?>EGP</button>
        </form>

      </div>
    </div>

  </body>
  <script type="text/javascript">
  $(document).ready(function(){
    var ele = document.getElementsByName('size');
    var sizeprice;
    var newval;
    var currentVal = parseInt($('input[name=quantity').val());
    $("input[id^='radio']").click(function() {
      sizeprice= $(this).val();
      $('input[name=quantity]').val(1);
      $('button[id=result]').html("Add to Basket " + (sizeprice * currentVal) + ".00EGP");
    });



      $('[data-quantity="plus"]').click(function(e){
          e.preventDefault();
          fieldName = $(this).attr('data-field');
          var currentVal = parseInt($('input[name='+fieldName+']').val());
          if (!isNaN(currentVal)) {
              $('input[name='+fieldName+']').val(++currentVal);
              newprice= sizeprice * currentVal;
              $('button[id=result]').html("Add to Basket " + (sizeprice * currentVal) + ".00EGP");
          } else {
              $('input[name='+fieldName+']').val(1);
          }
      });
      $('[data-quantity="minus"]').click(function(e) {
          e.preventDefault();
          fieldName = $(this).attr('data-field');
          var currentVal = parseInt($('input[name='+fieldName+']').val());
          if (!isNaN(currentVal) && currentVal > 1) {
              $('input[name='+fieldName+']').val(currentVal - 1);
              $('button[id=result]').html("Add to Basket " + ((currentVal * sizeprice) - sizeprice) + ".00EGP");
          } else {
              $('input[name='+fieldName+']').val(1);
          }
      });
  });


  </script>
</html>
