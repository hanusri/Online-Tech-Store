<?php
session_start();
require_once('config.php');


    if(isset($_GET["action"]) && isset($_GET["userid"]))
    {      		
    	// Load data when page loads
    	if($_GET["action"] == "n")
    	{ 
	        loadData();
    	} 
    	// Update Quantity
    	if($_GET["action"] == "u")
    	{
    	    updateAvailableQuantity();		
    		updateQuantity();    		
			loadData();
    	} 
    	// delete product
    	if($_GET["action"] == "d")
    	{
    		updateAvailableQuantityfordelete();
    		deleteproduct();    	      		
			loadData();
    	} 
    	// checkout
    	if($_GET["action"] == "c")
    	{
    		checkout();    		  	      		
			loadData();
    	}            	
    }

function loadData()
{
	try{    
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$user = $db->quote($_GET["userid"]);
		$query = $db->prepare("SELECT UC.*,P.ImageURL,P.Sale_Price,P.Name,P.Available_Quantity,UC.QUANTITY*P.SALE_PRICE AS 'Total_Price' FROM 
	          USER_CART UC INNER JOIN PRODUCT P ON P.PRODUCT_CODE = UC.PRODUCT_CODE WHERE UC.USER_ID = $user");
	    $query->execute();
	    $rows=$query->fetchAll();

	    if($rows)
	    {        	
	       echo json_encode($rows);
	    }
	    else
	    	echo "";
    }catch(PDOException $ex){
		echo $ex->getMessage(); 
	}
}

function updateQuantity()
{
	try{		 
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE USER_CART SET Quantity = :quantity           
        WHERE Product_Code = :productcode AND User_Id = :userid";        
		$query = $db->prepare($sql);                                  
		$query->bindParam(':quantity', $_GET["quantity"], PDO::PARAM_INT);
		$query->bindParam(':productcode', $_GET["productcode"], PDO::PARAM_STR); 
		$query->bindParam(':userid', $_GET["userid"], PDO::PARAM_STR);  		
		$query->execute();				
    }catch(PDOException $ex){
		echo $ex->getMessage(); 
	}
}

function updateAvailableQuantityfordelete()
{
	try{    
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//update available quantity when product removed from cart
        $productcode = $db->quote($_GET["productcode"]);
        $user = $db->quote($_GET["userid"]);
        $query = $db->prepare("SELECT P.Available_Quantity,UC.Quantity FROM PRODUCT P INNER JOIN 
        	USER_CART UC ON UC.PRODUCT_CODE = P.PRODUCT_CODE WHERE P.PRODUCT_CODE = $productcode and UC.USER_ID=$user");
        $query->execute();
        $rows=$query->fetchAll();
        $availablequantity = array_values($rows)[0]["Available_Quantity"];
        $existingquantity = array_values($rows)[0]["Quantity"];
        $availablequantity = $availablequantity + $existingquantity;
        $sql = "UPDATE PRODUCT SET Available_Quantity = :availablequantity           
            WHERE Product_Code = :productcode";
		$query = $db->prepare($sql);                                  
		$query->bindParam(':availablequantity', $availablequantity, PDO::PARAM_INT);
		$query->bindParam(':productcode', $_GET["productcode"], PDO::PARAM_STR);   
		$query->execute();
	 }catch(PDOException $ex){
		echo $ex->getMessage(); 
	}
}

function updateAvailableQuantity()
{
	try{    
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//update available quantity
        $productcode = $db->quote($_GET["productcode"]);
        $user = $db->quote($_GET["userid"]);
        $query = $db->prepare("SELECT P.Available_Quantity,UC.Quantity FROM PRODUCT P INNER JOIN 
        	USER_CART UC ON UC.PRODUCT_CODE = P.PRODUCT_CODE WHERE P.PRODUCT_CODE = $productcode and UC.USER_ID=$user");
        $query->execute();
        $rows=$query->fetchAll();
        $availablequantity = array_values($rows)[0]["Available_Quantity"];
        $existingquantity = array_values($rows)[0]["Quantity"];
        $newquantity = $_GET["quantity"];        
        $availablequantity = $availablequantity - ($newquantity - $existingquantity);		
        $sql = "UPDATE PRODUCT SET Available_Quantity = :availablequantity           
            WHERE Product_Code = :productcode";
		$query = $db->prepare($sql);                                  
		$query->bindParam(':availablequantity', $availablequantity, PDO::PARAM_INT);
		$query->bindParam(':productcode', $_GET["productcode"], PDO::PARAM_STR);   
		$query->execute();
	 }catch(PDOException $ex){
		echo $ex->getMessage(); 
	}
}

function deleteproduct()
{
	try{
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	    $sql = "DELETE FROM USER_CART WHERE Product_Code = :productcode AND User_Id = :userid";        
		$query = $db->prepare($sql);	
		$query->bindParam(':productcode', $_GET["productcode"], PDO::PARAM_STR); 
		$query->bindParam(':userid', $_GET["userid"], PDO::PARAM_STR);  		
		$query->execute();
	 }catch(PDOException $ex){
		echo $ex->getMessage(); 
	}
}

function checkout()
{
	try{
		$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//insert order_history table
		 $sql = "INSERT INTO ORDER_HISTORY(User_Id,
	            Order_date,
	            Payment_Status) VALUES (
	            :userid, 
	            :currentdate, 
	            :status)";

		$query = $db->prepare($sql);
		$query->bindParam(':userid', $_GET["userid"], PDO::PARAM_STR);
		$current_date = date("Y-m-d H:i:s"); 
        $query->bindParam(':currentdate', $current_date, PDO::PARAM_STR); 
        $status = 'Paid';
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $orderid=$db->lastInsertId();
		// select data from product, user_cart
		$user = $db->quote($_GET["userid"]);
		$query = $db->prepare("SELECT UC.*,P.Sale_Price FROM USER_CART UC INNER JOIN PRODUCT P ON P.PRODUCT_CODE = UC.PRODUCT_CODE WHERE UC.USER_ID = $user");
        $query->execute();
        $rows=$query->fetchAll();
        $finalprice = 0;
        foreach ($rows as $row) 
        {
        	$finalprice = $finalprice + $row['Sale_Price'];
        	//insert into order_detail table
        	$sql = "INSERT INTO ORDER_DETAIL(Order_Id,
	            Product_Code,
	            Quantity,Item_Price) VALUES (
	            :orderid, 
	            :code, 
	            :quantity,
	            :itemprice)";
			$query = $db->prepare($sql);
			$query->bindParam(':orderid', $orderid, PDO::PARAM_INT); 
	        $query->bindParam(':code', $row['Product_Code'], PDO::PARAM_STR);
	        $query->bindParam(':quantity', $row['Quantity'], PDO::PARAM_INT); 
	        $query->bindParam(':itemprice', $row['Sale_Price'], PDO::PARAM_STR); 
	        $query->execute();
        }
        // update final price
        $sql = "UPDATE ORDER_HISTORY SET Final_Price = :finalprice WHERE Order_ID = :orderid";        
		$query = $db->prepare($sql);                                  
		$query->bindParam(':finalprice', $finalprice, PDO::PARAM_STR);
		$query->bindParam(':orderid', $orderid, PDO::PARAM_INT);		
		$query->execute();
		
		// delete from cart
		$sql = "DELETE FROM USER_CART WHERE User_Id = :userid";        
		$query = $db->prepare($sql);			
		$query->bindParam(':userid', $_GET["userid"], PDO::PARAM_STR);  		
		$query->execute();
	}catch(PDOException $ex){
	echo $ex->getMessage(); 
	}
}

?>