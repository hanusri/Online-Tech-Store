$(document).ready(function() {
	// Insert span tag
	$("#uname").after("<span>Please enter only letters or numbers</span>");
	$("#pwd").after("<span>The password should be at least 8 characters</span>");
	$("span").hide();

     // All operations of the Username field
    $('#uname').blur('input', function() {
    $( this ).next( "span" ).hide(); //Notification is initially hidden
    $( this ).next( "span" ).removeClass("info"); // Removes info class from span
    $( this ).next( "span" ).removeClass("ok");   // Removes ok class from span
    $( this ).next( "span" ).removeClass("error");  // Removes error class from span

	var input=$(this);
	var username=input.val();
	var str=/^[a-zA-Z0-9]+$/;   // Checking if username has only characters or numbers
	if(username.match(str) && username.length >= 5 && username.length<=10){
	$( this ).next( "span" ).text(" ").append('<i style="display:inline;color: #3a7d34;">&#10004;</i>');
	$( this ).next( "span" ).show().addClass("ok"); //If username has only characters then , ok class should be assigned
	}
	else{
		$( this ).next( "span" ).text("Username should contain alphanumeric characters having length 5-10").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");  //If username is invalid, error should be displayed
	    $('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });

	    }

});

 $('#pwd').blur('input', function() {    	
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
		$( this ).next( "span" ).text("Please enter a valid password having length 8-16").append('<i style="display:inline;color: #FF0000;">&#10008;</i>').show().addClass("error");  //If password is invalid, error should be displayed
	    $('#submit').click(function () {
        $('input[type=submit]').attr("disabled", "disabled");
        $('input[type=submit]').css("background-color", "grey");
        return false;
        });
	}
});
//var validator = $( ".login" ).validate();  // Validating the form
//validator.form();   
});
