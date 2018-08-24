function getAdminLogin()
{
	$('#login-container').load("/include/admin_login.html", function(){
    loaded();
    $('#admin-login').submit(function(event)
    {
    	event.preventDefault();
    }).validate({
    	rules: {
    			usern: {required: true},
    			passwd: {required: true}
    	},
    	messages: {
    		usern: "Please enter your username",
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
			response = $.parseJSON(response);
			if(response.status == "200"){
				$.ajax({
					url: "/include/config.html",
					success: function(response){
						$('body').append(response);
						$.getScript("/script/js/ts_config.js");
						$.getScript("/script/js/common_config.js");
						$.getScript("/script/js/gameserver_config.js");
						$('#login-container').hide();
					}
				});
			}
			else {
				errorHandler(response);
				getAdminLogin();
			}
		}
	});
}

$(document).ready(function(){
  getAdminLogin();
});
