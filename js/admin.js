window.onload = function() {
  if($("#usercategory").html() == "A")
  {
    getData('n','','all','all');
  }
  else
  {
    $("#divdata").html("<span class = 'error'>You dont have access to view the products</span>");
  }
  //search button click
  $("#btngo").click(function()
  {
    getData('n','',$('#ddnbrand').val(),$('#ddncategory').val());           
  });
   $("#btnnew").click(function()
  {
    if($("#usercategory").html() == "A")
    {
      window.location.href = "addproduct.php";  
     }    
     else
     {
      alert("Sorry, you dont have right access to create product");
     }    
  });

  $("#imgsearch").click(function()
  {
    window.location.href = "productlist.php?q=" + $(".search").val();
  });
}


function getData(actionvalue,productcodevalue,brandvalue,categoryvalue)
{

  $.ajax({
   url: "adminaction.php",
   async: false,
   cache:false,       
   data: { action: actionvalue, productcode: productcodevalue,brand: brandvalue,category: categoryvalue},         
   success: function(data) {    
    if(data === '')
    {
      $("#divdata").html(data);
    }   
    else
    {
      console.log(data);
      data = $.parseJSON(data);         
      loadData(data);       
    } 
   },
      error: function() { alert("Please try again later");  }
    }); 
}

function loadData(data)
{
  var output="";
  for (var i in data) 
  {
      output+="<div class='product'>";
      output+="<div class='product-image'><img src='img/productdetails/"+ data[i].ImageURL +"'></div>";
      output+="<div class='product-details'><a href='addproduct.php?productcode=" + data[i].Product_Code + "'>" + data[i].Name +"</a></div>";      
      output+="<div class='product-category'>"+ data[i].Category +"</div>";
      output+="<div class='product-brand'>"+ data[i].Brand +"</div>";
      output+="<div class='product-price'>"+ data[i].Sale_Price +"</div>";
      output+="<div class='product-quantity'>"+ data[i].Available_Quantity +"</div>";     
      output+="<div class='product-removal'><button class='remove-product' productcode='"+ data[i].Product_Code +"'>Remove</button></div>";      
      output+="</div>";      
  }   
  $("#divdata").html(output); 
  reloadButtonClicks();
}

function reloadButtonClicks()
{
  // delete product from list
  $(".remove-product").click(function()
  {
     if (confirm('Are you sure you want to delete this product?')) 
      {
        getData('d',$(this).attr("productcode"),'all','all');
      }      
  });  

}