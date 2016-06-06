<?php
// Start the session
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/default.css" type="text/css" media="all"/>
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="js/home.js" type="text/javascript"></script>
    </head>
    <title>Grab it Up</title>
  <body>
<!--Header-->
<?php include 'menu.php';?>

<!--Image slideshow-->
    <div id="slideshow-container">
	   <figure id="slideshow" max-width="50px">
        <img src="img/home/home.png">
	 	    <img src="img/home/Phone.png" alt>
		    <img src="img/home/Laptop.png" alt>
        <img src="img/home/Tablet.png" alt>
		    <img src="img/home/Watch.png" alt>
		    <img src="img/home/TV.png" alt>
		    <img src="img/home/Accessories.png" alt>
	   </figure>
    </div>

<!--Home Screen thumbnail images for other pages-->
    <div id="thumb">
      <img src="img/thumb/thumb3.png" id="imgdealmonth" alt="">
      <img src="img/thumb/thumb7.png" id="imgdealweek" alt="">
    </div>
    <!--Footer-->
    <?php include 'footer.php';?>
  </body>
</html>