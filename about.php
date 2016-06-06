<?php
// Start the session
session_start();
?>
     <!--Header-->
    <?php include 'menu.php';?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <link href="styles/default.css" rel="stylesheet">
    <title>About</title>
</head>
<body id="aboutusbody">

    <!--Config-->
    <?php require_once('config.php');?>
     <span id="userid" class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span> 
     <span class="hide"><?php echo $_SESSION[SESSION_USER][USERID_COLUMN] ?></span>

    <img class="aboutimage" src="img/home/Black.png"/>
    <div class="about">
        <p>
            Grab it Up is an Online Technology Store that offers wide range of latest techs. As our company has grown and our software has evolved, our focus has remained unchanged since the inception of Grab it Up in 2016. We provide effective online tools to help people connect with the rapidly evolving technology.
        </p>
    </div>

    <div class="clear"></div>
    <!--Footer-->
    <?php include 'footer.php';?>        
</body>
</html>