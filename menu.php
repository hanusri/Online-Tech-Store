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
echo '<header>
     <div id="menucontainer">
      <ul class="pageheader">
        <li id="logo">
            <a href="home.php">
            <img src="img/home/white.png">
            </a>
        </li>
        <li class="menulist"><a href="productlist.php">All</a></li>
        <li class="menulist"><a href="productlist.php?p=phone">Phone</a></li>
        <li class="menulist"><a href="productlist.php?p=computer">Computer</a></li>        
        <li class="menulist"><a href="productlist.php?p=watch">Watch</a></li>
        <li class="menulist"><a href="productlist.php?p=tv">TV</a></li>
        <li class="menulist"><a href="productlist.php?p=accessories">Accessories</a></li>
        <a href="editProfile.php">'.$username.'</a>';
        if($_SESSION[USERINFO][CATEGORY_COLUMN] == "A"){
            echo '<li class="useritem" id="icons"><a href="adminlist.php"><img src="img/home/admin.png"></a></li>';
        }
        if($_SESSION[USERINFO][CATEGORY_COLUMN] == "U"){
             echo   '<li class="useritem" id="icons"><a href="ordersummary.php"><img src="img/home/order.png"></a></li>
                    <li class="useritem" id="icons"><a href="checkout.php"><img src="img/home/bag.png"></a></li>
                    <li class="useritem cart"><span id="cartCount">'.$cartcount.'</span></li>';
        }       
        echo '<li class="useritem">
        <div class="searchtab">
            <span>
            <input type="text" class="search"/>
            <img src="img/home/search.png" id="imgsearch"/>
            </span>
        </div>
        </li>
        <li class="useritem" id="icons"><a href="signin.php"><img src="img/home/user.png"></a></li>
        <li class="useritem" id="icons"><a href="signout.php"><img src="img/home/logout.png"></a></li>
      </ul>
      </div>
    </header>';
?>