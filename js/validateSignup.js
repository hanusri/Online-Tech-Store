	$(document).ready(function() {
	// Insert span tag
	$("#userid").after("<span>Please enter only letters or numbers</span>");
	$("#password").after("<span>The password should be at least 8 characters</span>");
	$("#dob").after("<span>Enter your date of birth</span>");
	$("#firstname").after("<span>First name should have only letters</span>");
	$("#middlename").after("<span>Middle name should have only letters</span>");
	$("#lastname").after("<span>Last name should have only letters</span>");
	$("#emailaddress").after("<span>Please enter a valid email</span>");
	$("#contact").after("<span>Please enter a valid phone number</span>");
	$("span").hide();

	// All operations of the Username field
	$('#userid').blur('input', function() {
		
	$( this ).next( "span" ).hide(); //Notification is initially hidden
	$( this ).next( "span" ).removeClass("info"); // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");   // Removes ok class from span
	$( this ).next( "span" ).removeClass("error");  // Removes error class from span

	var input=$(this);
	var username=input.val();
	var str=/^[a-zA-Z0-9]+$/;
	if(username.match(str) && username.length >= 5 && username.length<=10)
	{
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok");
    }
	$.ajax({ 
	url: "signupValidation.php", 
	type: 'GET',
	data:{newuserid: username},
	success:function(data){	
	if(data==1){
	$(this).next( "span" ).text("Please enter a valid Username").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");
	$('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}
	},
	error: function() { alert("Error adding user. Please try again");  }
	});
	});
	//All operations for password
	$('#password').blur('input', function() {    	
	$( this ).next( "span" ).hide();
	$( this ).next( "span" ).removeClass("info");    // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");// Removes ok class from span
	$( this ).next( "span" ).removeClass("error");// Removes error class from span
	var input=$(this);
	var user_pass=input.val();
	var len = user_pass.length;
	if(len >= 8 && len<=16){  
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok"); //If password is greatr than 7 characters then , ok class should be assigned

	}
	else{
	//$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #FF0000;">&#10008;</i>');
	$( this ).next( "span" ).text("Password should be between 8 and 16 characters").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");  //If password is invalid, error should be displayed
	$('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}
	});

	$('#dob').blur('input', function() {  
	$( this ).next( "span" ).hide();
	$( this ).next( "span" ).removeClass("info");    // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");// Removes ok class from span
	$( this ).next( "span" ).removeClass("error");
	//var datePat = /^(\d{4})(\d{1,2})(\/|-)(\d{1,2})$/;

	/*// To require a 4 digit year entry, use this line instead:
	//var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{4})$/;*/
	//var matchArray = dob.match(datePat); // is the format ok?
	var input=$(this);
	var dob=input.val();
	if (dob.length==10) {
		$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	    $( this ).next( "span" ).show().addClass("ok");
	}
	else{
		$( this ).next( "span" ).text("Enter a valid date of birth in yyyy/mm/dd format").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");
	    $('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
       });
	}
    });
	//All operations for first name
	$('#firstname').blur('input', function() {
	$( this ).next( "span" ).hide(); //Notification is initially hidden
	$( this ).next( "span" ).removeClass("info"); // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");   // Removes ok class from span
	$( this ).next( "span" ).removeClass("error");  // Removes error class from span

	var input=$(this);
	var fname=input.val();
	var str=/^[a-zA-Z]+$/;   // Checking if firstname has only characters
	if(fname.match(str) && fname.length<=50){
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok"); //If firstname has only characters then , ok class should be assigned
	}
	else{
	//$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #FF0000;">&#10008;</i>');
	$( this ).next( "span" ).text("Enter a valid first name").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");  //If firstname is invalid, error should be displayed
    $('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}
	});
	//All operations for middle name
	$('#middlename').blur('input', function() {
	$( this ).next( "span" ).hide(); //Notification is initially hidden
	$( this ).next( "span" ).removeClass("info"); // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");   // Removes ok class from span
	$( this ).next( "span" ).removeClass("error");  // Removes error class from span

	var input=$(this);
	var mname=input.val();
	var str=/^[a-zA-Z]+$/;   // Checking if middlename has only characters 
	if(mname.match(str) && mname.length<=50){
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok"); //If middlename has only characters then , ok class should be assigned
	}
	/*else{
	//$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #FF0000;">&#10008;</i>');
	$( this ).next( "span" ).text("Enter a valid middle name").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");  //If middlename is invalid, error should be displayed
     $('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}*/
	});
	//All operations for last name
	$('#lastname').blur('input', function() {
	$( this ).next( "span" ).hide(); //Notification is initially hidden
	$( this ).next( "span" ).removeClass("info"); // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");   // Removes ok class from span
	$( this ).next( "span" ).removeClass("error");  // Removes error class from span

	var input=$(this);
	var lname=input.val();
	var str=/^[a-zA-Z]+$/;   // Checking if middlename has only characters 
	if(lname.match(str) && lname.length<=50){
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok"); //If middlename has only characters then , ok class should be assigned
	}
	else{
	//$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #FF0000;">&#10008;</i>');
	$( this ).next( "span" ).text("Enter a valid last name").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");  //If middlename is invalid, error should be displayed
    $('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}
	});
	//All operations for contact
	$('#contact').blur('input', function() {
	$( this ).next( "span" ).hide(); //Notification is initially hidden
	$( this ).next( "span" ).removeClass("info"); // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");   // Removes ok class from span
	$( this ).next( "span" ).removeClass("error");  // Removes error class from span

	var input=$(this);
	var contact=input.val();
	var str=/^[0-9]+$/;   // Checking if contact has only characters 
	if(contact.match(str) && contact.length==10){
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok"); //If contact has only numbers then , ok class should be assigned
	}
	else{
	//$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #FF0000;">&#10008;</i>');
	$( this ).next( "span" ).text("Enter a valid contact number").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");  //If contact is invalid, error should be displayed
    $('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}
	});
	//All validations for email
	$('#emailaddress').blur('input', function() {    	
	$( this ).next( "span" ).hide();
	$( this ).next( "span" ).removeClass("info");    // Removes info class from span
	$( this ).next( "span" ).removeClass("ok");// Removes ok class from span
	$( this ).next( "span" ).removeClass("error");// Removes error class from span
	var input=$(this);
	var user_email=input.val();
	if (validateEmail(user_email)){
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok");
	}
	else{
	//$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #FF0000;">&#10008;</i>');
	$( this ).next( "span" ).text("Enter a valid email").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");
	$('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}
	function validateEmail(user_email) {
	var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if (filter.test(user_email)) {
	return true;
	}
	else {
	return false;
	}
	}
	});
	//var validator = $( ".signup" ).validate();  // Validating the form
	//validator.form();   
	});