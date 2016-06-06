<?php
session_start();
?>
      <!--Header-->
    <?php include 'menu.php';?>
<!DOCTYPE html>
<html >
<head>   
  <link rel="stylesheet" href="styles/default.css">
  <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="js/checkout.js" type="text/javascript"></script>
  <title>Shopping bag</title>
</head>
<body id="checkoutpage">  

    <!-- Add Config file -->
    <?php require_once('config.php');?>
    <span id="userid" class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span>
        <h1>Items in your bag</h1> 
    <div id="errormessage">
     <span class="added hide"></span>
     <span class="failed hide"></span>
  </div>
  <div class="shopping-cart">
    <div class="column-labels">
      <label class="product-image">Image</label>
      <label class="product-details">Product Name</label>
      <label class="product-price">Sale Price</label>
      <label class="product-quantity">Quantity</label>
      <label class="product-removal">Remove</label>
      <label class="product-total-price">Total</label>
    </div>
    <div id="divdata">
    </div>
      <div class="total">
        <div class="total-item total-item-total">
        <label>Final Price</label>
          <div class="total-value" id="cart-total"></div>
        </div>       
        <button class="checkout">Checkout</button>
      </div>
    </div>
<div class="clear"></div>   
    <!--Footer-->
    <?php include 'footer.php';?>
</body>
</html>
