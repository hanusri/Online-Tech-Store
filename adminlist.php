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
  <script src="js/admin.js" type="text/javascript"></script>
  <title>Admin Product Maintenance</title>
</head>
<body id="adminlistpage">  
    <!-- Add Config file -->
    <?php require_once('config.php');?>
    <span id="userid" class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span>
    <span id="usercategory" class="hide"><?php echo $_SESSION[SESSION_USER][CATEGORY_COLUMN] ?></span>
        <h1>Products List Inventory</h1> 
    <div id="errormessage">
     <span class="added hide"></span>
     <span class="failed hide"></span>
    </div>
    <div id="searchcriteria">
      <span>Brand </span>
      <select id="ddnbrand">
      <option value="all" selected>All</option>
      <option value="dell">Dell</option>
      <option value="asus">Asus</option>
      <option value="apple">Apple</option>
      <option value="samsung">Samsung</option>
      <option value="lg electronics">LG Electronics</option>
      <option value="sony">Sony</option>
      <option value="vizio">Vizio</option>
      <option value="garmin">Garmin</option>
      <option value="fitbit">Fitbit</option>
    </select>
    <span>Category </span>
      <select id="ddncategory">
      <option value="all" selected>All</option>
      <option value="computer">Computer</option>
      <option value="phone">Phone</option>
      <option value="tv">TV</option>
      <option value="watch">Watch</option>
      <option value="accessories">Accessories</option>      
    </select>
    <div id="btngo" class="gobutton">Search</div>
    <div id="btnnew" class="newbutton">New Product</div>
    </div>
   <div class="clear"></div> 
  <div class="admin-products">
    <div class="column-labels">
      <label class="product-image">Image</label>
      <label class="product-details">Product Name</label>
      <label class="product-category">Category</label>
      <label class="product-brand">Brand</label>
      <label class="product-price">Sale Price</label>
      <label class="product-quantity">Available Quantity</label>
      <label class="product-removal">Remove</label>      
    </div>   
    <div id="divdata">
    </div>  
  </div>    
<div class="clear"></div>   
    <!--Footer-->
    <?php include 'footer.php';?>   
</body>
</html>
