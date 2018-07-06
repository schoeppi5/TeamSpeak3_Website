function queryCurrentUser()
{
  $.ajax({
		type : 'POST',
		url  : './script/php/db_request_user.php',
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
        $('#profile-email-container').html(response.email);
        $('#profile-username-container').html(response.username);
			}
			else
			{
        console.log(response.message);
			}
		}
	});
}

$(document).ready(function()
{
  queryCurrentUser();


});
