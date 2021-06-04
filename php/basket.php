

<?php
include 'classes.php';
session_start();
//session_unset();
if(isset($_POST["submit"]))
{

  $temp=explode(",",$_POST["submit"]);
  if($temp[0]=="cust")
  {



   unset($_SESSION['custom'][$temp[1]]);

  }
  elseif ($temp[0]=="Drink") {

    unset($_SESSION['drinks_basket'][$temp[1]]);
  }
}

if(!isset($_SESSION['drinks_basket']))
{
  $_SESSION['drinks_basket']=array();

}
if(!isset($_SESSION['custom']))
{
  $_SESSION['custom']=array();

}
?>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Rosario" />
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>


body
{
 font-family:Roboto;
}

h1
{
  text-align:center;
  margin-top: 3%;
  font-size: 36px;
}

h5
{
  font-size: 18px;

}

.itemimg
{
  border-radius: 20px;
  float: left;

}
.cointainer
{

}
.card
{

padding-left: 5px;
padding-top: 5%;
}

.name,.price,.quantity
{

padding-left: 13%;
font-size: 13px;
}
.name
{
padding-top: 1%;
 font-size: 18px;
 font-weight: bold;
}
.price
{
padding-top: 2%;
font-weight: bold;
}
.quantity
{
  margin-left: 13%;
  margin-top: -2.5%;
  font-weight:50;
}
.remove
{
  margin-left: 27.5%;
  margin-top: -5.5%;
  background-color: #964B00;
  color: white;
}


.sum
{
  margin-left: 5px;
  margin-top: 4%;
  font-size: 22px;

}

.tab {
    display: inline-block;
    margin-left: 15%;
}
.checkbut
{
  width: 25%;
  background-color: #964B00;
  color: white;
  font-weight: bold;
  font-size: 18px;
  font-family: Rosario;
  height: 40px;
}
.Total
{
  font-size: 30px;
  font-weight: bold;
}
.totalamount
{
  font-size: 22px;
  font-weight: bolder;
}
.subtotal,.Tax
{
  font-weight: lighter;
  font-size: 22px;
}
.subammount,.taxamount
{
  font-size: 19px;
  font-weight: lighter;
}
table
{
  margin-left: -110px;
  border: none;
  border-spacing: 110px 4px;
}




</style>



<h1>Basket<h1>
<h5>Order Details <h6>

<div class='cointainer';
  <?php


  $name;
  $price;
  $quan;
  $photopath;
  $subtotal=0;
  $tax;
  $items="";
  $quantities="";


  $arr2=$_SESSION['custom'];

  foreach ($arr2 as $key => $item) {
    $size=$item['size'];
    if ($size==0) {
      $size="Small";
    }
    elseif ($size==6) {
      $size="Meduim";
    }
    else {
      $size="Large";
    }
    $quan=$item['quantity'];
    $beverage=new Beverage(null);
    $beverage->by_id($item['bev']);
    $name=$beverage->get_name();
    $price=$beverage->get_price();
    $condprice=0;
    $conds="";
    foreach ($item['conds'] as $value) {
      $cond=new Condiment(null);
      $cond->by_id($value);
      $condname=$cond->get_name();
      $condprice+=$cond->get_price();
      $conds.=$condname.",";



    }

    $conds= rtrim($conds, ",");
    $items.= $name.", ".$size.",".$conds."-";
    $quantities.=$quan."-";
    //$subtotal+=$price*$quan;
   ?>

    <div class="card">

    <img class="itemimg " src="../Images/cust.png" width="12%" height="15%">

    <div class="name">
    <?php echo $name." ".$size." "."($conds)";?>
    </div>

    <div class="price">
    <?php echo ($price+$condprice);?>
    </div>
    <div class="quantity">
    <?php echo "quantity :".$quan;?>
    </div>
    <form class="" action="" method="post">
      <button type="submit" class="remove" value="<?php echo "cust,".$key; ?>" name="submit">
        X
    </form>


    </div>
    <?php
    $subtotal+=($price+$condprice)*$quan;
  }




  //session_unset();


$arr=$_SESSION['drinks_basket'];
  $i=0;
  for($i;$i<sizeof($arr);$i++)
  {

    $name=$arr[$i][0];
    $size=$arr[$i][1];
    $price=$arr[$i][2];
    $quan=$arr[$i][3];
    $photopath=$arr[$i][4];
    $items.= $name.", ".$size."-";
    $quantities.=$quan."-";
    $subtotal+=$price*$quan;


  ?>

    <div class="card">

    <img class="itemimg " src="<?php echo $photopath ?>" width="12%" height="15%">

    <div class="name">
    <?php echo $name." ".$size;?>
    </div>

    <div class="price">
    <?php echo $price;?>
    </div>
    <div class="quantity">
    <?php echo "quantity :".$quan;?>
    </div>
    <form class="" action="" method="post">
      <button type="submit" class="remove" value="<?php echo "Drink,".$i; ?>" name="submit">
        X
    </form>

    </div>

    <?php
        }
    ?>
    <?php
      $tax=$subtotal*0.14;
      $items=rtrim($items, "-");
      $quantities=rtrim($quantities, "-");
      $order=new Order(null);
      $arr1=[];
      $arr1['items']=$items;
      $arr1['quantity']=$quantities;
      $arr1['price']=$subtotal+$tax;
      if(isset($_POST['check']))
      {
       $order->by_data($arr1);
       $_SESSION['order'] = $order->get_id();
      }

     ?>

    <div class="sum">
    <div class="subtotal">
      <table>
        <tr>
          <td class="subtotal">Subtotal</td>
          <td class="subammount"><?php echo $subtotal." ";?>EGP</td>

          </tr>
        <tr>
          <td class="tax">Tax:</td>
          <td class="taxamount"><?php echo $tax." ";?>EGP</td>
        </tr>
        <tr>
          <td class="total">Total:</td>
          <td class="totalamount"><?php echo $subtotal+$tax." ";?>EGP</td>
        </tr>
      </table>
    </div>
    <form class="" action="" method="post">
      <input type="submit" onclick="checkout()" class="checkbut"  name="check" value="Checkout">
    </form>

  </div>
  <?php
    echo "<script>
    function checkout() {
      alert('Your order is successfully placed. Your order number is $_SESSION[order]')
    }
    </script>";
    unset($_SESSION['order']);
  ?>
