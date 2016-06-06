<?php
ob_start();
session_start();
?>
    <!--Header-->
    <?php include 'menu.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link href="styles/editprofile.css" rel="stylesheet">
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="js/editProfile.js" type="text/javascript"></script>
    <title>Edit Profile</title>
</head>
<body id="editprofilebody">
<?php
require_once('config.php');
$userid=$_SESSION[SESSION_USER][USERID_COLUMN];
$pwd=$_SESSION[SESSION_USER][PASSWORD_COLUMN];
$dateofbirth=$_SESSION[SESSION_USER][DATE_OF_BIRTH_COLUMN];
$firstname=$_SESSION[SESSION_USER][USERNAME_COLUMN];
$middlename=$_SESSION[SESSION_USER][MIDDLE_NAME_COLUMN];
$lastname=$_SESSION[SESSION_USER][LAST_NAME_COLUMN];
$emailaddress=$_SESSION[SESSION_USER][EMAIL_COLUMN];
$phonenumber=$_SESSION[SESSION_USER][PHONE_COLUMN];
?>
<div id="editprofilediv">
<form method="POST" action="editProfile.php" name="editProfile" class="edit">
<p>Username
<input type="text" name="uid" class="addinput" id="userid" value="<?php echo $userid?>" readonly /></p>
<p>Password
<input type="password" name="pwd" class="addinput" id="password" value="<?php echo $pwd ?>" /></p>
<p>Date of Birth
<input type="date" name="dob" class="addinput" id="dob" value="<?php echo $dateofbirth?>" /></p>
<p>First Name
<input type="text" name="fname" class="addinput" id="firstname" value="<?php echo $firstname?>" /></p>
<p>Middle Name
<input type="text" name="mname" class="addinput" id="middlename" value="<?php echo $middlename?>" /></p>
<p>Last Name
<input type="text" name="lname" class="addinput" id="lastname" value="<?php echo $lastname?>" /></p>
<p>Email
<input type="email" name="email" class="addinput" id="emailaddress" value="<?php echo $emailaddress?>" /></p>
<p>Phone Number
<input type="number" name="phone" class="addinput" id="contact" value="<?php echo $phonenumber?>" /></p>
<br><br><p>
<input type="submit" name="submitted" id="submit1" value="Update" align="bottom" /></p>
</form>
</div>
<?php
if(isset($_POST['submitted']))
{
editProfile();
}
function editProfile(){
try{    
$db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$user = $db->quote($_POST["uid"]);
$password = $db->quote($_POST["pwd"]);
$dob = $db->quote($_POST["dob"]);
$fname = $db->quote($_POST["fname"]);
$mname = $db->quote($_POST["mname"]);
$lname = $db->quote($_POST["lname"]);
$email = $db->quote($_POST["email"]);
$phone = $db->quote($_POST["phone"]);
$updateQuery = $db->prepare("UPDATE USER SET User_Id=$user,Password=$password
    ,Date_Of_Birth=$dob,First_Name=$fname,Middle_Name=$mname,Last_Name=$lname,
    Email=$email,Phone=$phone WHERE User_Id=$user");
$result = $updateQuery->execute();
$query = $db->prepare("SELECT * FROM USER WHERE User_Id = $user");
$query->execute();
$rows=$query->fetchAll();
$_SESSION[SESSION_USER] = array_values($rows)[0];
header("Location: home.php");   
}
catch(PDOException $ex){
echo "<script type='text/javascript'>alert('$ex->getMessage();');</script>"; 
}
}
?>
    <div class="clear"></div>
    <!--Footer-->
    <?php include 'footer.php';?>
</body>
</html>