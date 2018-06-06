$('#login-form').submit(function(event)
{
	event.preventDefault();
}).validate({
	rules: {
			pass: {required: true},
			email: {required: true, email: true},
	},
	messages: {
		pass:{required: "No Password"},
		email: "No E-mail",
	},
	errorPlacement: function(error, element) {
		element.attr("placeholder", error.text());
	},
	submitHandler: function() {
		submitForm();
	}
});


function submitForm()
{
	var data = $("#login-form").serialize();
	data = data + "&action=login";

	$.ajax({
		type : 'POST',
		url  : '/script/php/login.php',
		data : data,
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
				$('#login-con').load("/include/profile.html", function()
				{
					$('#usernameField').html(response.username);
					$('#mailField').html(response.email);
				});
			}
			else
			{
				errorHandler(response);
			}
		}
	});
}

function errorHandler(response)
{
	switch(response.status)
	{
		case "403":
		$('#pass').val("");
		$('#pass').attr("placeholder", response.message);
		break;
		case "404":
		$('#email').val("");
		$('#email').attr("placeholder", response.message);
		break;
		default: console.log(response.status + ": " + response.message);
	}
}

function rememberLogin()
{
	$.ajax({
		type : 'POST',
		url  : '/script/php/login.php',
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
				$('#login-con').load("/include/profile.html", function()
				{
					$('#usernameField').html(response.username);
					$('#mailField').html(response.email);
				});
			}
			else
			{
				errorHandler(response);
			}
		}
	});
}
