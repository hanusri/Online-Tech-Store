<?php
require_once('config.php');
if(isset($_SESSION[USERINFO]))
{
    $username = '<li class="useritem welcomename">Hi '.$_SESSION[USERINFO][USERNAME_COLUMN].'!</li>';
     try{
        $db = new PDO("mysql:dbname=".DBNAME.";host=".DBHOST, DBUSER, DBPASS);  
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user = $db->quote($_SESSION[USERINFO][USERID_COLUMN]);        
        $query = $db->prepare("SELECT * FROM USER_CART WHERE User_Id = $user");
        $query->execute();
        $rows=$query->fetchAll();
        $cartcount = count($rows);
     }catch(PDOException $ex){
        
     }
}
else
{
    $user = "";
}
echo '<footer><br/><br/>
      <center>Grab it Up! </center><br/>
      <ul id="pagefooter">
        <li><a href="home.php">HOME</a></li>
        <li><a href="productlist.php">PRODUCTS</a></li>
        <li><a href="productlist.php?deal=all">DEALS</a></li>
        <li><a href="signup.php">SIGNUP</a></li>
        <li><a href="about.php">ABOUT</a></li>
      </ul> 
  </footer>';
?>