

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

<div class="cointainer">
<div class="card">

<img class="itemimg " src="../images/cappucino.jpg" width="12%" height="15%">

<div class="name">
Meduim <br> capaccuino
</div>

<div class="price">
42 EGP
</div>
<div class="quantity">
Quantity : 1
</div>
<button class="remove">
X
</div>

<div class="cointainer">
<div class="card">

<img class="itemimg " src="../images/cappucino.jpg" width="12%" height="15%">

<div class="name">
Meduim <br> capaccuino
</div>

<div class="price">
42 EGP
</div>
<div class="quantity">
Quantity : 1
</div>
<button class="remove">
X
</div>

<div class="cointainer">
<div class="card">

<img class="itemimg " src="../images/cappucino.jpg" width="12%" height="15%">

<div class="name">
Meduim <br> capaccuino
</div>

<div class="price">
42 EGP
</div>
<div class="quantity">
Quantity : 1
</div>
<button class="remove">
X
</div>
<div class="card">

<img class="itemimg " src="../images/cappucino.jpg" width="12%" height="15%">

<div class="name">
Meduim <br> capaccuino
</div>

<div class="price">
42 EGP
</div>
<div class="quantity">
Quantity : 1
</div>
<button class="remove">
X
</div>
<div class="sum">
  <div class="subtotal">
    <table>
      <tr>
        <td class="subtotal">Subtotal</td>
        <td class="subammount">98 EGP</td>
      </tr>
      <tr>
        <td class="tax">Tax:</td>
        <td class"taxamount">100 EGP</td>
      </tr>
      <tr>
        <td class="total">Total:</td>
        <td class="totalamount">110 EGP</td>
      </tr>
    </table>
  </div>
  <button onclick="checkout()" class="checkbut"> Checkout
</div>
</div>

<script>
function checkout() {
  alert("Your order is successfully placed ")
}
</script>
