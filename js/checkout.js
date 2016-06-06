window.onload = function() {
  
  getData($("#userid").text(),'n','','');
  //update quantity  
  //reloadButtonClicks();

  $(".checkout").click(function(){
    if($("#divdata").html() == "")
    {
      alert("No products added to cart to checkout. Please add products to cart.");
    }
    else if(confirm('Please click OK to purchase')) 
    {      
      getData($("#userid").text(),'c','','');
    }    
  });

  $("#imgsearch").click(function()
  {
    window.location.href = "productlist.php?q=" + $(".search").val();
  });
}


function getData(user_id,actionvalue,productcodevalue,quantityvalue)
{

  $.ajax({
   url: "checkoutaction.php",
   async: false,
   cache:false,       
   data: { action: actionvalue, userid: user_id,productcode: productcodevalue,quantity: quantityvalue},         
   success: function(data) {    
    if(actionvalue === 'c')
    {
      window.location.replace("ordersummary.php");
    } 
    else
    { 
      if(data === '')
      {
        $("#divdata").html(data);
        $("#cartCount").text(data);
        $("#cart-total").text(data)
      }   
      else
      {
        data = $.parseJSON(data);         
        loadData(data);       
      } 
    }
   },
   error: function() { alert("Please try again later");  }
    }); 
}

function loadData(data)
{  
  var finalprice = parseFloat("0.00");
  var output="";
  var count = 0;
  for (var i in data) 
  {
      output+="<div class='product'>";
      output+="<div class='product-image'><img src='img/productdetails/" + data[i].ImageURL +"'></div>";
      output+="<div class='product-details'>";
      output+="<div class='product-title'>"+ data[i].Name +"</div></div>";
      output+="<div class='product-price'>"+ data[i].Sale_Price +"</div>";
      output+="<div class='product-quantity'><input class='product-quantity-input' value='"+ data[i].Quantity +
      "' type='number' min='1' /><button class='update-product' availablequantity='" + data[i].Available_Quantity + "' productcode='"+ data[i].Product_Code +"'>Update</button></div>";
      output+="<div class='product-removal'><button class='remove-product' productcode='"+ data[i].Product_Code +"'>Remove</button></div>";
      output+="<div class='product-total-price'>" + data[i].Total_Price + "</div>";
      output+="</div>";
      finalprice = finalprice + parseFloat(data[i].Total_Price);
      count = count + 1;
  } 
  
  $("#divdata").html(output);
  $("#cart-total").text(finalprice.toFixed(2));
  $("#cartCount").text(count);
  reloadButtonClicks();
}

function reloadButtonClicks()
{
  // update quantity
  $(".update-product").click(function()
  {
    if(parseInt($(this).prev().val()) > parseInt($(this).attr("availablequantity")))
    {
      $(".failed").html("Sorry! Product is out of stock");
      $(".failed").fadeIn(6000,function()
          {
            $(".failed").fadeOut('slow',function(){
              getData($("#userid").text(),'n','','');
            })
      });
    }
    else
    {
      getData($("#userid").text(),'u',$(this).attr("productcode"),$(this).prev().val());
      $(".added").html("Quantity Updated");
      $(".added").fadeIn(6000,function()
          {
            $(".added").fadeOut('slow',function(){
              
            })
      });
    }
  });

  // delete product from cart
  $(".remove-product").click(function()
  {    
      getData($("#userid").text(),'d',$(this).attr("productcode"),'');      
  });  
}