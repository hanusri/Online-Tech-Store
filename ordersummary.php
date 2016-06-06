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
    <script src="js/home.js" type="text/javascript"></script>
</head>
<body id="ordersummarypage">
    <!-- Add Config file -->
    <?php require_once('config.php');?>
    <span id="userid" class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span> 
    <h1>Thanks for Grabbing our Product</h1>
  <div class="order-cart">
    <div class="orderlabel">
      <label class="order-details">Order Details</label>
      <label class="order-brand">Brand</label>
      <label class="order-category">Category</label>
      <label class="order-date">Purchase Date</label>
      <label class="order-price">Savings</label>
      <label class="order-total-price">Amount Paid</label>
  </div>
</div>
  <div class="order">
        <?php
        try
        {    
        $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $userid=$db->quote($_SESSION[SESSION_USER][USERID_COLUMN]);
          $query = $db->prepare("SELECT name,category,brand,list_price-sale_price,item_price,order_date FROM product p
                                 INNER JOIN order_detail od ON p.product_code=od.product_code
                                 INNER JOIN order_history oh ON oh.order_id=od.order_id
                                 AND oh.USER_ID=$userid");
          $query->execute();
          $rows=$query->fetchAll();                
          foreach ($rows as $row) { ?>
    <div class="order-details">
      <div class="order-title"><?php echo $row['name']; ?></div>
    </div>
    
    <div class="order-brand"><?php echo $row['brand']; ?></div>

    <div class="order-category"><?php echo $row['category']; ?></div>

    <div class="order-date"><?php echo $row['order_date']; ?></div>

    <div class="order-price"><?php echo $row['list_price-sale_price']; ?></div>
      
    <div class="order-total-price"><?php echo $row['item_price']; ?></div>

                  <?php }
            }catch(PDOException $ex){
                echo $ex->getMessage(); 
            }
            ?> 
  </div>
  <div class="wrapper">
      <a href="home.php">
      <button class="checkoutorder">Home</button></a>
  </div>

    <div class="clear"></div>
    <!--Footer-->
    <?php include 'footer.php';?>

</body>
</html>