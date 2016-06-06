<?php
// Start the session
session_start();
?>
    <!--Header-->
    <?php include 'menu.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="styles/default.css" rel="stylesheet">
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="js/home.js" type="text/javascript"></script>
    <title>Shop your desired product</title>
</head>
<body>

    <!-- Add Config file -->
    <?php require_once('config.php');
    $brandfilter = "";
    if(isset($_GET["b"]))
    {
        $brandfilter = $_GET["b"];
    }
    ?>
    <h1>Your shopping gets a makeover</h1> 
    <div class="container">
        <span id="userid" class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span> 
        <span class="added hide">Item added</span>
        <span class="failed hide">Sorry! Product is out of stock</span>
        <div id="searchcriteria">
                <span>Brand </span>
              <select id="ddnbrand">
              <option value="all" <?php if ($brandfilter === '') echo ' selected="selected"' ?>>All</option>
              <option value="dell" <?php if (strtolower($brandfilter) === 'dell') echo ' selected="selected"' ?>>Dell</option>
              <option value="asus" <?php if (strtolower($brandfilter) === 'asus') echo ' selected="selected"' ?>>Asus</option>
              <option value="apple" <?php if (strtolower($brandfilter) === 'apple') echo ' selected="selected"' ?>>Apple</option>
              <option value="samsung" <?php if (strtolower($brandfilter) === 'samsung') echo ' selected="selected"' ?>>Samsung</option>
              <option value="lg electronics" <?php if (strtolower($brandfilter) === 'lg electronics') echo ' selected="selected"' ?>>LG Electronics</option>
              <option value="sony" <?php if (strtolower($brandfilter) === 'sony') echo ' selected="selected"' ?>>Sony</option>
              <option value="vizio" <?php if (strtolower($brandfilter) === 'vizio') echo ' selected="selected"' ?>>Vizio</option>
              <option value="garmin" <?php if (strtolower($brandfilter) === 'garmin') echo ' selected="selected"' ?>>Garmin</option>
              <option value="fitbit" <?php if (strtolower($brandfilter) === 'fitbit') echo ' selected="selected"' ?>>Fitbit</option>
              </select>
        </div>
        <div id="divresult">
            <?php
                try{    
                $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $brand="";
                if(isset($_GET["b"]) && strtolower($_GET["b"]) != 'all')
                {
                    $brandvalue = $db->quote($_GET["b"]);
                    $brand = " AND Brand = ".$brandvalue;
                }               
                if(isset($_GET["p"]))
                {
                    $category=$db->quote($_GET["p"]);
                    $query = $db->prepare("SELECT * FROM PRODUCT WHERE Category = $category AND Deleted <> 'Y'".$brand);
                }
                elseif (isset($_GET["latest"]))
                {
                    $query = $db->prepare("SELECT * FROM PRODUCT WHERE Latest_Flag = 'Y' AND Deleted <> 'Y'".$brand);
                }
                elseif (isset($_GET["deal"]))
                {

                    $dealtype = $db->quote($_GET["deal"]);                       
                    if(strtolower($dealtype) === "'all'")
                    {
                        $query = $db->prepare("SELECT * FROM PRODUCT P INNER JOIN PRODUCTDEAL PD ON 
                        PD.PRODUCT_CODE = P.PRODUCT_CODE WHERE PD.STATUS='ACTIVE' AND P.Deleted <> 'Y'".$brand);                        
                    }
                    else
                    {
                        $query = $db->prepare("SELECT * FROM PRODUCT P INNER JOIN PRODUCTDEAL PD ON 
                        PD.PRODUCT_CODE = P.PRODUCT_CODE WHERE PD.STATUS='ACTIVE' AND PD.DEAL_TYPE=$dealtype AND P.Deleted <> 'Y'".$brand);
                    }
                    $deal = true;                    
                }
                elseif (isset($_GET["q"]))
                {
                    $searchkey = "%".$_GET["q"]."%";
                    $searchkey = $db->quote($searchkey);
                    $query = $db->prepare("SELECT * FROM PRODUCT WHERE Deleted <> 'Y' AND (Name like $searchkey OR Description like $searchkey)".$brand);
                }
                else
                {
                    $query = $db->prepare("SELECT * FROM PRODUCT WHERE Deleted <> 'Y'".$brand);
                }
                $query->execute();
                $rows=$query->fetchAll();                
                foreach ($rows as $row) { ?>
                     <div class="col-sm-4 col-lg-4 col-md-4" id="bootstrap">
                        <div class="thumbnail">
                            <img src="<?php echo IMAGE_PATH.$row['ImageURL']; ?>" alt="Image not found"  />
                            <div class="caption">
                                <a href="productdetails.php?productcode=<?php echo htmlspecialchars($row['Product_Code']); ?>"><?php echo $row['Name']; ?></a>
                                <?php if(isset($_SESSION[USERINFO]) && $_SESSION[USERINFO][CATEGORY_COLUMN] == "U"){ ?> <br/>
                                <div class="cartbutton" productcode=<?php echo $row['Product_Code'];?>>
                                <img src="img/thumb/cart.png"/>
                                <? } ?>
                                <div id="saleprice">$<?php                                 
                                if(!$deal)                                    
                                    echo $row['Sale_Price'];
                                else
                                    echo $row['Sale_Price'] - $row['Discount_Price'] ?></div>
                                </div>
                             
                              <?php if(isset($_SESSION[USERINFO]) && $_SESSION[USERINFO][CATEGORY_COLUMN] == "U"){ ?>
                          </div>  <? } ?>


                                <span>List Price: <div id="listprice">$<?php echo htmlspecialchars($row['List_Price']); ?></div></span><br/>
                            <span id="spnavailable">Available: <span id="quantity"><?php echo htmlspecialchars($row['Available_Quantity']); ?></span></span>
                        </div>
                    </div>
                <?php }
            }catch(PDOException $ex){
                echo $ex->getMessage(); 
            }
            ?>        
        </div> 
    </div>
     <div class="clear"></div>
    <!--Footer-->
    <?php include 'footer.php';?>
</body>
</html>