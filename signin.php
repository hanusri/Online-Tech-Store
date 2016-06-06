<?php
// Start the session
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="styles/signin.css" type="text/css" media="all"/>
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="js/validateSignin.js" type="text/javascript"></script>
</head>
<body id="signinbody">
<div id="signindiv">
	<form method="POST" action="signin.php" name="signin" class="login">	

    <p><input type="text" name="uname" class="addinput" id="uname" placeholder="Username" /></p>
    <p><input type="password" name="pwd" class="addinput" id="pwd" placeholder="Password" /></p>

	<p><a href="forgotpassword.php">Having trouble?</a></p>
    <p><a href="signup.php">Create New User</a></p><br><br>
    <p><input type="submit" name="submitted" id="submit" value="Login"></input></p>
	</form>
</div>
</body>
</html>

<?php
require_once('config.php');
if(isset($_POST['submitted']))
{	
	Login();
}
function Login()
{
	//All validations are done in javascript
	try{    
        $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
        $user_id = $db->quote($_POST["uname"]);
        $password = $db->quote($_POST["pwd"]);        
        $query = $db->prepare("SELECT * FROM USER WHERE User_Id = $user_id AND Password = $password");
        $query->execute();
        $rows=$query->fetchAll();
        if($rows)
        {
        	$_SESSION[SESSION_USER] = array_values($rows)[0];
        	header("Location: home.php");			
        }
        else 
        	echo "<script type='text/javascript'>alert('Invalid credentials entered');</script>";
        
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('$ex->getMessage();');</script>"; 
    }
}
?>