window.onload = function() {
	if(document.getElementById('slideshow'))
	{
		var imgs = document.getElementById('slideshow').children;
		interval = 5000;
		currentPic = 0;
		imgs[currentPic].style.webkitAnimation = 'fadey '+interval+'ms';
		imgs[currentPic].style.animation = 'fadey '+interval+'ms';
		var infiniteLoop = setInterval(function(){
			imgs[currentPic].removeAttribute('style');
			if ( currentPic == imgs.length - 1) {
				currentPic = 0;
			} else {
				currentPic++;
			}
		imgs[currentPic].style.webkitAnimation = 'fadey '+interval+'ms';
		imgs[currentPic].style.animation = 'fadey '+interval+'ms';
		}, interval);
	}

	$("#slideshow-container").click(function()
	{
		window.location.href = "productlist.php?latest=Y";
	});

	$("#imgdealweek").click(function()
	{
		window.location.href = "productlist.php?deal=week";
	});

	$("#imgdealmonth").click(function()
	{
		window.location.href = "productlist.php?deal=month";
	});

	$("#imgsearch").click(function()
	{
		window.location.href = "productlist.php?q=" + $(".search").val();
	});

	$(".cartbutton").click(function(){
		var urlvalue = "updatecart.php?productcode="+$(this).attr("productcode")+"&userid="+$("#userid").text();
		var clickedCart = $(this);
		var availableQuantity = clickedCart.parent().siblings("#spnavailable").children("#quantity").text();
		var availableQuantityDetailsPage = $(".pdcontent #quantity").text();
		if(availableQuantity == "0" || availableQuantityDetailsPage == "0")
		{
			$(".failed").fadeIn(1000,function()
			 	{
			 		$(".failed").fadeOut(2000,function(){
			 			
			 		})
			 	});
		}
		else
		{
			$.ajax({
			 url: "updatecart.php",
			 cache:false,		 
			 data: { productcode: $(this).attr("productcode"), userid: $("#userid").text()},         
			 success: function(data) {
			 	if(data != "")
			 		$("#cartCount").text(data);
			 	$(".added").fadeIn(1000,function()
			 	{
			 		$(".added").fadeOut(2000,function(){
			 			var availableQuantityint = parseInt(availableQuantity); 
			 			var availableQuantityDetailsPageint = parseInt(availableQuantityDetailsPage);
			 			clickedCart.parent().siblings("#spnavailable").children("#quantity").text(availableQuantityint-1);
			 			$(".pdcontent #quantity").text(availableQuantityDetailsPageint-1)
			 		})
			 	});
			 		       
			 },
			 error: function() { alert("Error in adding cart. Please try later");  }
	     	});	
     	}	
	});

	$("#ddnbrand").change(function() {
		var currentaddress = window.location.href;
		if (currentaddress.indexOf("?") >= 0)
		{
			if(currentaddress.indexOf("&b") >= 0)
			{

				var brandquery = currentaddress.substring(currentaddress.indexOf("&b"));				
				currentaddress = currentaddress.replace(brandquery,"&b=" + $('#ddnbrand').val());
				window.location.href = currentaddress;
			}
			else
			{
				if(currentaddress.indexOf("?b") >= 0)
				{
					var brandquery = currentaddress.substring(currentaddress.indexOf("?b"));
					currentaddress = currentaddress.replace(brandquery,"?b=" + $('#ddnbrand').val());
					window.location.href = currentaddress;
				}
				else
				{
					window.location.href = currentaddress + "&b=" + $('#ddnbrand').val();
				}				
			}
		}
		else
		{
			window.location.href = currentaddress + "?b=" + $('#ddnbrand').val();			
		}
	});
}

