<?php
session_start();
?>
<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styles/signin.css" type="text/css">
	<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="js/validateSignup.js" type="text/javascript"></script>
	</head>
	<body id="signinbody">
	<div id="signindiv">
	<legend>SIGN-UP HERE</legend><br>
	<form method="POST" action="signup.php" name="signup" class="signup">
	
	<p>
	<input type="text" name="uid" class="addinput1" id="userid" placeholder="Username*" /></p>
	<p>
	<input type="password" name="pwd" class="addinput1" id="password" placeholder="Password*" /></p>
	<p>
	<input type="date" name="dob" class="addinput1" id="dob" placeholder="Date of Birth(yyyy-mm-dd)*" maxlength="10" /></p>
	<p>
	<input type="text" name="fname" class="addinput1" id="firstname" placeholder="First Name*" /></p>
	<p>
	<input type="text" name="mname" class="addinput1" id="middlename" placeholder="Middle Name" /></p>
	<p>
	<input type="text" name="lname" class="addinput1" id="lastname" placeholder="Last Name*" /></p>
	<p>
	<input type="email" name="email" class="addinput1" id="emailaddress" placeholder="Email*" /></p>
	<p>
	<input type="number" name="phone" class="addinput1" id="contact" placeholder="Phone Number" /></p><br><br>
	<p><input type="submit" name="submitted" id="submit" value="Sign Up" /></p>
	</form>
	</div>
	</body>
	</html>
	<?php
	//require_once('config.php');
	define('DBHOST', 'localhost:3306');
    define('DBUSER', 'root');
    define('DBPASS', 'root');
    define('DBNAME', 'test');
	if(isset($_POST['submitted']))
	{	
		Signup();
	}
	function Signup()
	{
	try{
	$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
	$user_id = $db->quote($_POST["uid"]);
	$password = $db->quote($_POST["pwd"]);
	$date_of_birth = $db->quote($_POST["dob"]);
	$first_name = $db->quote($_POST["fname"]);
	$middle_name = $db->quote($_POST["mname"]);
	$last_name = $db->quote($_POST["lname"]);
	$email = $db->quote($_POST["email"]);
	$phone = $db->quote($_POST["phone"]);
	$categoryvalue = "U";	
	$category = $db->quote($categoryvalue);	
	$str = $db->prepare("INSERT INTO `USER` (User_Id, Password, Date_Of_Birth, First_Name, Middle_Name, Last_Name, Email, Phone, Category) VALUES ($user_id, $password, $date_of_birth, $first_name, $middle_name, $last_name, $email, $phone, $category)");
	$str->execute();
	$count = $str->rowCount();
	if($count > 0)
	{
	echo "<script type='text/javascript'>alert('User added to database successfully!');</script>";
	header("Location:signin.php");
	}
	else
	{
	echo "<script type='text/javascript'>alert('$query->errorCode();');</script>";
	}
	}
	catch(PDOException $ex){
	echo "<script type='text/javascript'>alert('$ex->getMessage();');</script>";
	}
	}
	?>

