function getLogin()
{
  $.ajax({
		type : 'POST',
		url  : '/script/php/query_client_info.php',
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
        $.getScript("/script/js/user.js").done(function(){
          fillProfile(response);
        });
			}
			else
			{
				$('#profile-dashlet').load("/include/login.html");
        $.getScript("/script/js/login.js");
			}
		}
	});
}

function getTeamSpeak()
{
  $.ajax({
    type: "GET",
    url: "/include/teamspeak.html",
    success : function(text)
    {
       $('#ts-dashlet').append(text);
    }
  });

  $.getScript("/script/js/teamspeak.js").done(function()
  {
    loadInfo();
  });
}

function getServers()
{
  $.ajax({
    type: "GET",
    url: "/include/servers.html",
    success: function(response){
      $('#servers-dashlet').append(response);
      $.getScript("/script/js/servers.js");
    }
  });
}
