function getAdminLogin()
{
	$('#login-container').load("/include/admin_login.html", function(){
    loaded();
    $('#admin-login').submit(function(event)
    {
    	event.preventDefault();
    }).validate({
    	rules: {
    			username: {required: true},
    			passwd: {required: true}
    	},
    	messages: {
    		username: "Please enter your username",
    		passwd: "Please enter a password",
    	},
    	errorPlacement: function(error, element) {
    		element.attr("placeholder", error.text());
    	},
    	submitHandler: function() {
    		checkLogin();
    	}
    });
  });
}

function checkLogin(){
  $('#login-mask').hide();
  $('#login-container').css("background", "var(--bg-color) url('/img/loading.svg') no-repeat center center");

	var data = $('#admin-login').serialize();

	$.ajax({
		type: "POST",
		url: "/script/php/check_login_admin.php",
		data: data,
		success: function(response){
			console.log(response);
			response = $.parseJSON(response);
			$('#login-container').hide();
		}
	});
}

$(document).ready(function(){
  getAdminLogin();
});
