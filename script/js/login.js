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


function checkUID()
{
	var data = $("#uid").serialize();
	data = data + "&action=check";

	$.ajax({
		type : 'POST',
		url  : '/script/php/login.php',
		data : data,
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
				checked();
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
