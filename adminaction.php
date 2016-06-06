<?php
session_start();
require_once('config.php');
if(isset($_GET["action"]) && isset($_GET["productcode"]))
{ 
	// Load data when page loads
	if($_GET["action"] == "n")
	{
        loadData();
	} 	
	// delete product
	if($_GET["action"] == "d")
	{
		deleteproduct();
		loadData();
	}

	// validate product
	if($_GET["action"] == "v")
	{
		validateproductcode();
	}		           	
}

function loadData()
{
	try{
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql="SELECT Name,Category,Sale_Price,Available_Quantity,Product_Code,Brand,ImageURL FROM PRODUCT WHERE Deleted <> 'Y'";
		if(isset($_GET["brand"]) && $_GET["brand"] != "all")
		{
			$brand = $db->quote($_GET["brand"]);
			$sql = $sql." "."AND Brand = $brand";
		}		
		if(isset($_GET["category"]) && $_GET["category"] != "all")
		{
			$category = $db->quote($_GET["category"]);
			$sql = $sql." "."AND Category = $category";
		}		
		$query = $db->prepare($sql);
		$query->execute();
		$rows=$query->fetchAll();
		if($rows)
		{ 			
		   echo json_encode($rows);
		}
		else
			echo "";
			
	}catch(PDOException $ex){
		echo "Load Failed"; 
	}
}

function deleteproduct()
{
	try{
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$flag = "Y";
	    $sql = "UPDATE PRODUCT SET DELETED = :flag        
        WHERE Product_Code = :productcode";        
		$query = $db->prepare($sql);
		$query->bindParam(':flag', $flag, PDO::PARAM_INT);
		$query->bindParam(':productcode', $_GET["productcode"], PDO::PARAM_STR); 			
		$query->execute();
	 }catch(PDOException $ex){
		echo $ex->getMessage(); 
	}
}

function validateproductcode()
{
	try{
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$productcode = $db->quote($_GET["productcode"]);
		$query = $db->prepare("SELECT * FROM PRODUCT WHERE Product_Code = $productcode");
		$query->execute();
		$rows=$query->fetchAll();
		if($rows)
		{ 			
		   echo "1";
		}
		else
			echo "";
			
	}catch(PDOException $ex){
		echo "Load Failed"; 
	}
}

?>