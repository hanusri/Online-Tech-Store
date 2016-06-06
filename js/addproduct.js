$(document).ready(function() {
	$(".procode").after("<span id='spnprocode' style='display:none;margin-left:5px'>test</span>");
	$(".proname").after("<span id='spnproname' style='display:none;margin-left:5px'>test</span>");
	$("#txtlistprice").after("<span id='spnprolistprice' style='display:none;margin-left:5px'>test</span>");
	$("#txtsaleprice").after("<span id='spnprosaleprice' style='display:none;margin-left:5px'>test</span>");
	$(".prodescription").after("<span id='spndescription' style='display:none;margin-left:5px;position:relative;top:-100px'>test</span>");
	$(".prophoto").after("<span id='spnprophoto' style='display:none;margin-left:5px'>test</span>");
	$(".proquantity").after("<span id='spnproquantity' style='display:none;margin-left:5px'>test</span>");	
	
	if($('.procode').is('[readonly]') == false)
	{		
		$(".procode").focus(function(){
			$("#spnprocode").show().text("required and must be unique").removeClass("ok error").addClass("info");
		});

		// product code validation
		$(".procode").blur(function(){			
			var errorexists = false;
			var errormsg = "";
			var productcodevalue = $(this).val();
			var actionvalue = "v";
			if(productcodevalue == "")
			{
				errormsg = errormsg + "Required.";
				errorexists = true;
			}
			else
			{
				// ajax call to check for uniqueness pending
				$.ajax({
				   url: "adminaction.php",
				   type: 'GET',
				   async: false,
				   cache:false,       
				   data: { action: actionvalue, productcode: productcodevalue},         
				   success: function(data) {
						    if(data === '1')
						    {
						      errormsg = errormsg + "Product code already Exists";
							  errorexists = true;
						    }
				},
				error: function() { alert("Please try again later");  }
		    	}); 
			}

			if(errorexists)
			{
				$("#spnprocode").text(errormsg).removeClass("info ok").addClass("error");
			}
			else
			{
				$("#spnprocode").text("OK").removeClass("info error").addClass("ok");
			}
		});

	}

	$(".proname").focus(function(){		
		$("#spnproname").show().text("required").removeClass("ok error").addClass("info");
	});

	$("#txtlistprice").focus(function(){		
		$("#spnprolistprice").show().text("required and must be numeric").removeClass("ok error").addClass("info");
	});

	$("#txtsaleprice").focus(function(){		
		$("#spnprosaleprice").show().text("required and must be numeric").removeClass("ok error").addClass("info");
	});

	$(".prodescription").focus(function(){		
		$("#spndescription").show().text("required").removeClass("ok error").addClass("info");
	});

	$(".prophoto").focus(function(){		
		$("#spnprophoto").show().text("required").removeClass("ok error").addClass("info");
	});

	$(".proquantity").focus(function(){		
		$("#spnproquantity").show().text("required and must be a number").removeClass("ok error").addClass("info");
	});

	
	// product name validation
	$(".proname").blur(function(){
		var errorexists = false;
		var errormsg = "";
		var productname = $(this).val();
		if(productname == "")
		{
			errormsg = errormsg + "Required";
			errorexists = true;
		}
		
		if(errorexists)
		{
			$("#spnproname").text(errormsg).removeClass("info ok").addClass("error");
		}
		else
		{
			$("#spnproname").text("OK").removeClass("info error").addClass("ok");
		}
	});

	// List price validation
	$("#txtlistprice").blur(function(){		
		var errorexists = false;
		var errormsg = "";
		var listprice = $(this).val();
		if(listprice == "")
		{
			errormsg = errormsg + "Required.";
			errorexists = true;
		}
		else if(!$.isNumeric(listprice))
		{
			errormsg = errormsg + "Must be numeric values only.";
			errorexists = true;
		}
		
		if(errorexists)
		{
			$("#spnprolistprice").text(errormsg).removeClass("info ok").addClass("error");
		}
		else
		{
			$("#spnprolistprice").text("OK").removeClass("info error").addClass("ok");
		}
	});

	// Sale price validation
	$("#txtsaleprice").blur(function(){		
		var errorexists = false;
		var errormsg = "";
		var saleprice = $(this).val();
		if(saleprice == "")
		{
			errormsg = errormsg + "Required.";
			errorexists = true;
		}
		else if(!$.isNumeric(saleprice))
		{
			errormsg = errormsg + "Must be numeric values only.";
			errorexists = true;
		}
		
		if(errorexists)
		{
			$("#spnprosaleprice").text(errormsg).removeClass("info ok").addClass("error");
		}
		else
		{
			$("#spnprosaleprice").text("OK").removeClass("info error").addClass("ok");
		}
	});

	// Description Validation
	$(".prodescription").blur(function(){		
		var errorexists = false;
		var errormsg = "";
		var description = $(this).val();
		if(description == "")
		{
			errormsg = errormsg + "Required";
			errorexists = true;
		}
		
		if(errorexists)
		{
			$("#spndescription").text(errormsg).removeClass("info ok").addClass("error");
		}
		else
		{
			$("#spndescription").text("OK").removeClass("info error").addClass("ok");
		}
	});

	// Image URL Validation
	$(".prophoto").blur(function(){		
		var errorexists = false;
		var errormsg = "";
		var imageurl = $(this).val();
		if(imageurl == "")
		{
			errormsg = errormsg + "Required.";
			errorexists = true;
		}
		
		if(errorexists)
		{
			$("#spnprophoto").text(errormsg).removeClass("info ok").addClass("error");
		}
		else
		{
			$("#spnprophoto").text("OK").removeClass("info error").addClass("ok");
		}
	});

	// Quantity validation
	$(".proquantity").blur(function(){		
		var errorexists = false;
		var errormsg = "";
		var quantity = $(this).val();
		if(quantity == "")
		{
			errormsg = errormsg + "Required.";
			errorexists = true;
		}
		else if(!$.isNumeric(quantity))
		{
			errormsg = errormsg + "Must be numeric values only.";
			errorexists = true;
		}
		
		if(errorexists)
		{
			$("#spnproquantity").text(errormsg).removeClass("info ok").addClass("error");
		}
		else
		{
			$("#spnproquantity").text("OK").removeClass("info error").addClass("ok");
		}
	});

	$('#productform').on('submit', function(e){
    if ($(".error").length > 0){
        e.preventDefault();
        // alert('Fill in both fields');
        // You can use an alert or a dialog, but I'd go for a message on the page
        $('#errormsg').text('There are errors in the input field(s). Please correct and submit.').show();
    }else{
        // do nothing and let the form post
    } 
   
	});

	 $("#imgsearch").click(function()
	{
		window.location.href = "productlist.php?q=" + $(".search").val();
	});

});
