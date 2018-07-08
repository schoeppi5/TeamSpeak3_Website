$('#login-form').submit(function(event)
{
	event.preventDefault();
}).validate({
	rules: {
			uid: {required: true}
	},
	messages: {
		uid: "Please enter your unique identifier",
	},
	errorPlacement: function(error, element) {
		element.attr("placeholder", error.text());
	},
	submitHandler: function() {
		checkUID();
	}
});

$('#key-form').submit(function(event)
{
	event.preventDefault();
}).validate({
	rules: {
			code: {required: true}
	},
	messages: {
		code: "Please enter the key you recieved",
	},
	errorPlacement: function(error, element) {
		element.attr("placeholder", error.text());
	},
	submitHandler: function() {
		login();
	}
});


function checkUID()
{
	var data = $("#uid").serialize();

	$.ajax({
		type : 'POST',
		url  : './script/php/checkUid.php',
		data : data,
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
				$('#profile-dashlet').load("./include/key.html");
			}
			else
			{
				errorHandler(response);
			}
		}
	});
}

function login(){
	var data = $("#code").serialize();

	$.ajax({
		type : 'POST',
		url  : './script/php/login.php',
		data : data,
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
				$('#profile-dashlet').load("./include/key.html");
			}
			else
			{
				errorHandler(response);
			}
		}
	});
}

function rememberLogin()
{
	// $.ajax({
	// 	type : 'POST',
	// 	url  : './script/php/login.php',
	// 	success :  function(response) {
	// 		response = $.parseJSON(response);
	// 		if(response.status == "200")
	// 		{
	// 			$('#login-con').load("/include/profile.html", function()
	// 			{
	// 				$('#usernameField').html(response.username);
	// 				$('#mailField').html(response.email);
	// 			});
	// 		}
	// 		else
	// 		{
	// 			errorHandler(response);
	// 		}
	// 	}
	// });
}
