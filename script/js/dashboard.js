function getLogin()
{
  $.ajax({
    type: "GET",
    url: "./include/login.html",
    success : function(text)
    {
       $('#profile-dashlet').append(text);
    }
  });
}

function getTeamSpeak()
{
  $.ajax({
    type: "GET",
    url: "./include/teamspeak.html",
    success : function(text)
    {
       $('#ts-dashlet').append(text);
    }
  });

  $.getScript("./script/js/teamspeak.js").done(function()
  {
    loadInfo();
  });
}
