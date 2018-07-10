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

function login(){
	var data = $("#key-form").serialize();

	$.ajax({
		type : 'POST',
		url  : '/script/php/check_key.php',
		data : data,
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
				$.getScript("/script/js/user.js").done(function(){
          getClient();
        });
			}
			else
			{
				errorHandler(response);
			}
		}
	});
}
