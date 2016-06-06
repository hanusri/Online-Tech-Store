<?php
session_start();
require_once('config.php');
try{    
    $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_GET["productcode"]) && isset($_GET["userid"]))
    {
    	$product = $db->quote($_GET["productcode"]);
        $user = $db->quote($_GET["userid"]);        
        $query = $db->prepare("SELECT * FROM USER_CART WHERE User_Id = $user AND PRODUCT_CODE = $product");
        $query->execute();
        $rows=$query->fetchAll();
        if($rows)
        {        	
	        $quantity = array_values($rows)[0]["Quantity"];
	        $quantity = $quantity + 1;

	        $sql = "UPDATE USER_CART SET Quantity = :quantity           
	            WHERE Product_Code = :productcode AND USER_ID = :userid" ;
			$query = $db->prepare($sql);                                  
			$query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
			$query->bindParam(':productcode', $_GET["productcode"], PDO::PARAM_STR);
			$query->bindParam(':userid', $_GET["userid"], PDO::PARAM_STR);    
			$query->execute();	
        }
        else 
        {
	    	// insert new row in user_cart
	        $sql = "INSERT INTO USER_CART(User_Id,
	            Product_Code,
	            Quantity) VALUES (
	            :id, 
	            :code, 
	            :quantity)";

			$query = $db->prepare($sql);
			$query->bindParam(':id', $_GET["userid"], PDO::PARAM_STR); 
	        $query->bindParam(':code', $_GET["productcode"], PDO::PARAM_STR); 
	        $quantity = 1;
	        $query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
	        $query->execute();
	        $user = $db->quote($_SESSION[SESSION_USER][USERID_COLUMN]);        
	        $query = $db->prepare("SELECT * FROM USER_CART WHERE User_Id = $user");
	        $query->execute();
	        $rows=$query->fetchAll();	        
	        echo count($rows);
		}  

		//update available quantity
        $productcode = $db->quote($_GET["productcode"]);
        $query = $db->prepare("SELECT * FROM PRODUCT WHERE PRODUCT_CODE = $productcode");
        $query->execute();
        $rows=$query->fetchAll();
        $availablequantity = array_values($rows)[0]["Available_Quantity"];
        $availablequantity = $availablequantity - 1;

        $sql = "UPDATE PRODUCT SET Available_Quantity = :availablequantity           
            WHERE Product_Code = :productcode";
		$query = $db->prepare($sql);                                  
		$query->bindParam(':availablequantity', $availablequantity, PDO::PARAM_INT);
		$query->bindParam(':productcode', $_GET["productcode"], PDO::PARAM_STR);   
		$query->execute();   	
    }
}catch(PDOException $ex){
    echo $ex->getMessage(); 
}
?>