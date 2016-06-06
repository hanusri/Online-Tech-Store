<?php
// Start the session
ob_start();
session_start();
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
	<link rel="stylesheet" href="styles/signin.css" type="text/css" media="all"/>
	<title>Password Reset Request</title>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/validatePassword.js"></script>
	</head>
	<body id="signinbody">
	<div id="signindiv">
	<legend>RESET PASSWORD</legend>
	<form method="POST" action="forgotpassword.php" name="forgotpassword" class="forgotpassword">
	<p>
	<input type="text" name="uname" class="addinput" id="uname1" placeholder="Username" ></p>
	<p>
	<input type="password" name="pwd1" class="addinput" id="pass1" placeholder="Enter new password" /></p>
	<p>
	<input type="password" name="pwd2" class="addinput" id="pass2" placeholder="Confirm new password" /></p><br><br>
	<input type="submit" name="submitted" id="submit" value="Submit"></input><br><br>
	</form>
	</div>
	</body>
	</html>
	<?php
	require_once('config.php');
	if(isset($_POST['submitted']))
	{
	ForgotPassword();
	}
	function ForgotPassword(){
	try{    
	$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
	$user_id = $db->quote($_POST["uname"]);
	$password = $db->quote($_POST["pwd2"]); 
	$qry = $db->prepare("SELECT Password FROM USER WHERE User_Id=$user_id");
	$qry->execute();
	$rows=$qry->fetchAll();
	if(!$rows)
	{
	die("Bad Query!No entries in database found!");
	}
	if($_POST['pwd1']!= $_POST['pwd2'])
	{
	echo "<script type='text/javascript'>alert('Passwords do not match');</script>";
	}
	else
	{
	$update = $db->prepare("UPDATE USER SET Password=$password WHERE User_Id=$user_id");
	$result = $update->execute();
	if($result)
	{
	//echo "<script type='text/javascript'>alert('Password changed successfully. Login to your account.');</script>";
	header("Location:signin.php");
	}
	if(!$result){
	die ("Password change unsuccessful! Please try again!");
	}
	}
	}
	catch(PDOException $ex){
	echo $ex->getMessage(); 
	}
	}
	?>