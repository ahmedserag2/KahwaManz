<?php include 'classes.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="../master.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="container">
      <div class="bg">
        <img src="../images/images.jpg" alt="">
      </div>
    </div>

    <div class="menu-bg-c">
    <h1 class="customize-title">Make Your Own</h1>

    <div class="step step-1">
      <h2 class="step-title">Step 1: Choose Beverage</h2>
      <?php
        $beverage = new Beverage(NULL);
        $results = $beverage->select_all();
        foreach ($results as $result) { ?>

          <div class="step-option">
            <input class="step-radio" name="bevs" type="radio" id=<?php echo $result->get_id();?> value=<?php echo $result->get_id();?>>
            <label class="step-radio" style="margin-right:200px;" for=<?php echo $result->get_id();?>><?php echo $result->get_name();?></label>
            <label class="step-price" for=<?php echo $result->get_id();?>><?php echo $result->get_price(); ?></label><br>
          </div

        <?php echo "<br>";
        } ?>
    </div>

    <div class="step step-2">
      <h2 class="step-title">Step 2: Add Condiments</h2>
      <?php
        $beverage = new Condiment(NULL);
        $results = $beverage->select_all();
        foreach ($results as $result) { ?>

          <div class="step-option">
            <input class="step-radio" name="conds" type="radio" id=<?php echo $result->get_id();?> value=<?php echo $result->get_id();?>>
            <label class="step-radio" style="margin-right:200px; width:40px;" for=<?php echo $result->get_id();?>><?php echo $result->get_name();?></label>
            <label class="step-price" for=<?php echo $result->get_id();?>><?php echo $result->get_price(); ?></label><br>
          </div

        <?php echo "<br>";
        } ?>

    </div>

    <div class="step step-3" >
      <h2 class="step-title">Select Size</h2>
      <input id="radio"  type="radio" id="small" name="size" value="36.00">
          <label id="label" for="small">S</label>
          <input id="radio"  type="radio" id="medium" name="size" value="42.00">
          <label id="label"  for="medium">M</label>
          <input id="radio"  type="radio" id="large" name="size" value="50.00">
          <label id="label"  for="large">L</label>
    </div>

    <div class="step step-4">
      <h2 class="step-title">Quantity</h2>
        <button class="btn" style="position:relative;right:33%;" data-quantity="minus" data-field="quantity"><i class="fas fa-minus"></i></button>
         <input id="quantity" style="position:relative;right:33%;" type="number" name="quantity" value="1">
         <button class="btn" style="position:relative;right:33%;" data-quantity="plus" data-field="quantity"><i class="fas fa-plus"></i></button>
    </div>
    <div class="step step-5">
      <h2 style="float: left; font-size: 60px;">Price 0</h2>
      <button class="basket-c" id="result-c">Add to Basket 0 EGP</button>
    </div>
  </div>


  </body>
</html>
