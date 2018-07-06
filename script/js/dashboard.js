function getLogin()
{
  $.ajax({
    type: "GET",
    url: "include/login.html",
    success : function(text)
    {
       $('#profile-dashlet').append(text);
    }
  });
}
