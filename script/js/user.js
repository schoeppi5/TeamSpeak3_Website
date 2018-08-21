function getClient(){
	$.ajax({
		type : 'POST',
		url  : '/script/php/query_client_info.php',
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
        fillProfile(response);
			}
			else
			{
				errorHandler(response);
			}
		}
	});
}

function fillProfile(response){
  $('#profile-dashlet').load("/include/user.html", function(){
    $('#ts-user-name').html(response.client_name);
  });
}

function clientLogout(){
  $.ajax({
    type: 'POST',
    url: '/script/php/logout_client.php',
    success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
        getLogin();
			}
			else
			{
				errorHandler(response);
			}
		}
  })
}
