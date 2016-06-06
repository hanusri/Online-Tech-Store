<?php
// Start the session
session_start();
?>
    <!--Header-->
    <?php include 'menu.php';?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="styles/default.css" rel="stylesheet">
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="js/home.js" type="text/javascript"></script>
    <title>Product Details</title>
</head>
<body id="productdetailsbody">
    <!--Config-->
    <?php require_once('config.php');?>
    <span id="userid" class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span> 
     <span class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span> 
     <span class="added hide">Item added</span>
     <span class="failed hide">Sorry! Product is out of stock</span>
             <div id="divresult">
                <?php
                try
                {    
                $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if(isset($_GET["productcode"]))
                {
                    $productcode=$db->quote($_GET["productcode"]);
                    $query = $db->prepare("SELECT * FROM PRODUCT WHERE PRODUCT_CODE=$productcode");
                }
                else
                {
                    $query = $db->prepare("SELECT * FROM PRODUCT");
                }
                $query->execute();
                $rows=$query->fetchAll();                
                foreach ($rows as $row) { ?>
                <div id="pdcontainer" class="pdcontent">
                    <img class="photodesc" src="<?php echo IMAGE_PATH.$row['ImageURL']; ?>"/>
                    <div class="pddescription">
                        <p class="pdtitle"><u><?php echo $row['Name']; ?></u> 
                        <span class="pdprice">Price: $<?php                                 
                        if(!$deal)                                    
                            echo $row['Sale_Price'];
                        else
                            echo $row['Sale_Price'] - $row['Discount_Price'] ?></span>
                        </p>
                        <p><?php echo $row['Description']; ?></p>
                            <b><span>List Price: <div id="listprice">$<?php echo $row['List_Price']; ?></div></span><br/> 
                            <span id="spnavailable">Available: <span id="quantity"><?php echo $row['Available_Quantity']; ?></span></span><br/></b>
                <?php if(isset($_SESSION[USERINFO]) && $_SESSION[USERINFO][CATEGORY_COLUMN] == "U"){ ?>
                <div id="buybutton" class="cartbutton" productcode=<?php echo $row['Product_Code'];?>>Buy</div> 
                <?php } ?>
                </div>
                </div>
            <?php } }
            catch(PDOException $ex){
                echo $ex->getMessage(); 
            }
            ?> 
        </div> 

    <div class="clear"></div>
    <!--Footer-->
    <?php include 'footer.php';?>
</body>
</html>