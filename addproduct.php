<?php
session_start();
?>
     <!--Header-->
    <?php include 'menu.php';?>
<!DOCTYPE HTML>
<html>
<head>
 	<link rel="stylesheet" href="styles/default.css">
  <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="js/addproduct.js" type="text/javascript"></script>
  <title>Product Maintenance</title>
</head>
<body id="addadminpage">
    <!-- Add Config file -->
    <?php require_once('config.php');?>
    <span id="userid" class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span>
        <h1>Product Maintenance</h1> 
    <div id="errormessage">
     <span class="added hide"></span>
     <span class="failed hide"></span>
    </div>
    <!-- Fetch product info for pre population -->
    <?php
      if(isset($_GET["productcode"])) 
      {        
        try
        {
            echo htmlspecialchars($_SESSION["error"]);
            $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $productcode = $db->quote($_GET["productcode"]);
            $query = $db->prepare("SELECT * FROM PRODUCT WHERE Product_Code=$productcode");
            $query->execute();
            $rows=$query->fetchAll();
            $productcode=$rows[0]["Product_Code"];
            $name=$rows[0]["Name"];
            $category=$rows[0]["Category"];
            $brand=$rows[0]["Brand"];
            $listprice=$rows[0]["List_Price"];
            $saleprice=$rows[0]["Sale_Price"];
            $description=$rows[0]["Description"];            
            $imagefilename=$rows[0]["ImageURL"];
            $quantity=$rows[0]["Available_Quantity"];
            $latestflag=$rows[0]["Latest_Flag"];
            $shippingflag=$rows[0]["FreeShip_Flag"];            
          }catch(PDOException $ex){
            echo $ex->getMessage(); 
          }
        }      
    ?>
    <div class="admindiv">
    <form method="POST" action="addproduct.php" name="addproduct" id="productform">
        <input type="hidden" name="lblproductcode" value="<?php echo htmlspecialchars($_GET["productcode"]); ?>">
        <div class="labelsection"><span>Product Code</span></div><div class="inputsection"><input type="text" class="addinput procode" name="procode" placeholder="Product Code" value="<?php echo htmlspecialchars($productcode) ?>" <?php if (strlen($_GET["productcode"]) > 0) echo ' readonly' ?>/></div><br/>
        <div class="labelsection"><span>Name</span></div><div class="inputsection"><input type="text" class="addinput proname" name="name" placeholder="Product Name" value="<?php echo htmlspecialchars($name) ?>" /></div><br/>
        <div class="labelsection"><span>Category</span></div>
        <div class="inputsection">
            <select name="ddlcategory" class="addinput procategory">
                <option value="Computer"   <?php if ($category === 'Computer') echo ' selected="selected"' ?>>Computer</option>
                <option value="Phone"   <?php if ($category === 'Phone') echo ' selected="selected"' ?>>Phone</option>
                <option value="TV"   <?php if ($category === 'TV') echo ' selected="selected"' ?>>TV</option>
                <option value="Watch"   <?php if ($category === 'Watch') echo ' selected="selected"' ?>>Watch</option>
                <option value="Accessories"   <?php if ($category === 'Accessories') echo ' selected="selected"' ?>>Accessories</option>
            </select>
        </div><br/>
        <div class="labelsection"><span>Brand</span></div><div class="inputsection">
            <select name="ddlbrand" class="addinput probrand">
                <option value="Dell"   <?php if ($brand === 'Dell') echo ' selected="selected"' ?>>Dell</option>
                <option value="Asus"   <?php if ($brand === 'Asus') echo ' selected="selected"' ?>>Asus</option>
                <option value="Apple"   <?php if ($brand === 'Apple') echo ' selected="selected"' ?>>Apple</option>
                <option value="Samsung"   <?php if ($brand === 'Samsung') echo ' selected="selected"' ?>>Samsung</option>               
                <option value="LG Electronics"   <?php if ($brand === 'LG Electronics') echo ' selected="selected"' ?>>LG Electronics</option>
                <option value="Sony"   <?php if ($brand === 'Sony') echo ' selected="selected"' ?>>Sony</option>
                <option value="Vizio"   <?php if ($brand === 'Vizio') echo ' selected="selected"' ?>>Vizio</option>
                <option value="Garmin"   <?php if ($brand === 'Garmin') echo ' selected="selected"' ?>>Garmin</option>
                <option value="Fitbit"   <?php if ($brand === 'Fitbit') echo ' selected="selected"' ?>>Fitbit</option>
            </select>
        </div><br/>
        <div class="labelsection"><span>List Price</span></div><div class="inputsection"><input type="text" class="addinput proprice" id="txtlistprice" name="listprice" placeholder="List Price" value="<?php echo htmlspecialchars($listprice) ?>" /></div><br/>
        <div class="labelsection"><span>Sale Price</span></div><div class="inputsection"><input type="text" class="addinput proprice" id="txtsaleprice" name="finalprice" placeholder="Sale Price" value="<?php echo htmlspecialchars($saleprice) ?>" /></div><br/>
        <div class="labelsection"><span>Description</span></div><div class="inputsection"><textarea class="addinput prodescription" name="description" placeholder="Description"><?php echo htmlspecialchars($description); ?></textarea></div><br/>
        <div class="labelsection"><span>Image File Name</span></div><div class="inputsection"><input type="text " class="addinput prophoto" name="image" placeholder="Image" value="<?php echo htmlspecialchars($imagefilename) ?>" /></div><br/>
       	<div class="labelsection"><span>Available Quantity</span></div><div class="inputsection"><input type="text" class="addinput proquantity" name="quantity" placeholder="0" value="<?php echo htmlspecialchars($quantity) ?>" /></div><br/>
        <div class="labelsection"><span>Latest Product (Y/N)</span></div><div class="inputsection">
            <select name="ddllatest" class="addinput prolatest">
                <option value="Y"   <?php if ($latestflag === 'Y') echo ' selected="selected"' ?>>Yes</option>
                <option value="N"   <?php if ($latestflag === 'N') echo ' selected="selected"' ?>>No</option>                
            </select>
        </div><br/>
        <div class="labelsection"><span>Free Shipping (Y/N)</span></div><div class="inputsection">
            <select name="ddlshipping" class="addinput proshipping">
                <option value="Y"   <?php if ($shippingflag === 'Y') echo ' selected="selected"' ?>>Yes</option>
                <option value="N"   <?php if ($shippingflag === 'N') echo ' selected="selected"' ?>>No</option>                
            </select>
        </div><br/>
        <br/>
        <input type="submit" name="btnadd" value="ADD" class="addbutton"/>
        <a href="adminlist.php"><input value="CANCEL" class="cancelbutton"/></a>
        <label id="errormsg" class="submiterror" style="display:none;"></label>
    </form>
    </div>
<div class="clear"></div>   
    <!--Footer-->
    <?php include 'footer.php';?>
</body>
</html>
<?php

if(isset($_POST["btnadd"]))
{   
    if(strlen($_POST["lblproductcode"]) > 0)
    {
        // Update
        UpdateProduct();        
    }
    else
    {
        // insert product
        InsertProduct();
    }
    //header("Location: addproduct.php?productcode=".$_POST["procode"]);
    header("Location: adminlist.php");
}

function InsertProduct()
{
    
    try{
        $deletedvalue = "N";
        $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
        $sql = "INSERT INTO PRODUCT(Product_Code,Name, Description, ImageURL, List_Price,Sale_Price,Category,Brand, Available_Quantity,Latest_Flag,FreeShip_Flag,Deleted) VALUES (:productcode, :name, :description, :imageurl, :listprice, :saleprice, :category, :brand, :quantity, :latest, :shipping, :deletedflag)";
        $query = $db->prepare($sql);
        $query->bindParam(':productcode', $_POST["procode"], PDO::PARAM_STR);        
        $query->bindParam(':name', $_POST["name"], PDO::PARAM_STR); 
        $query->bindParam(':description', $_POST["description"], PDO::PARAM_STR); 
        $query->bindParam(':imageurl', $_POST["image"], PDO::PARAM_STR); 
        $query->bindParam(':listprice', $_POST["listprice"], PDO::PARAM_STR);         
        $query->bindParam(':saleprice', $_POST["finalprice"], PDO::PARAM_STR);
        $query->bindParam(':category', $_POST["ddlcategory"], PDO::PARAM_STR);
        $query->bindParam(':brand', $_POST["ddlbrand"], PDO::PARAM_STR);
        $query->bindParam(':quantity', $_POST["quantity"], PDO::PARAM_STR);
        $query->bindParam(':latest', $_POST["ddllatest"], PDO::PARAM_STR);
        $query->bindParam(':shipping', $_POST["ddlshipping"], PDO::PARAM_STR);
        $query->bindParam(':deletedflag', $deletedvalue, PDO::PARAM_STR);
        $query->execute();        
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('iNSERT operation failed');</script>"; 
    }
}

function UpdateProduct()
{
    
    try{    
        $deletedvalue = "N";
        $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
        $sql = "UPDATE PRODUCT SET Name = :name, Description = :description, ImageURL = :imageurl, List_Price = :listprice, Sale_Price = :saleprice, Category = :category, Brand = :brand, Available_Quantity = :quantity,Latest_Flag = :latest,FreeShip_Flag = :shipping,Deleted = :deletedflag WHERE Product_Code = :productcode";

        $query = $db->prepare($sql);        
        $query->bindParam(':productcode', $_POST["procode"], PDO::PARAM_STR);        
        $query->bindParam(':name', $_POST["name"], PDO::PARAM_STR); 
        $query->bindParam(':description', $_POST["description"], PDO::PARAM_STR); 
        $query->bindParam(':imageurl', $_POST["image"], PDO::PARAM_STR); 
        $query->bindParam(':listprice', $_POST["listprice"], PDO::PARAM_STR);         
        $query->bindParam(':saleprice', $_POST["finalprice"], PDO::PARAM_STR);
        $query->bindParam(':category', $_POST["ddlcategory"], PDO::PARAM_STR);
        $query->bindParam(':brand', $_POST["ddlbrand"], PDO::PARAM_STR);
        $query->bindParam(':quantity', $_POST["quantity"], PDO::PARAM_STR);
        $query->bindParam(':latest', $_POST["ddllatest"], PDO::PARAM_STR);
        $query->bindParam(':shipping', $_POST["ddlshipping"], PDO::PARAM_STR);
        $query->bindParam(':deletedflag', $deletedvalue, PDO::PARAM_STR);        
        $query->execute();                
    }catch(PDOException $ex){
        echo "Server down. Try again later"; 
    }
}

?>