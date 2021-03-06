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

	$.ajax({
		type : 'POST',
		url  : '/script/php/checkUid.php',
		data : data,
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
				$('#profile-dashlet').load("/include/key.html");
				$.getScript("/script/js/key.js");
			}
			else
			{
				errorHandler(response);
			}
		}
	});
}
