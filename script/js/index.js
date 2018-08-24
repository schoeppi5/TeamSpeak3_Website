$(document).ready(function(){
	configNeeded();
	$('#main').load("/include/dashboard.html", function()
	{
		$.getScript("/script/js/dashboard.js").done(function()
		{
			getLogin();
			getTeamSpeak();
			resize();
		});
	});
});
