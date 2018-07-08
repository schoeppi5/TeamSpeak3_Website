function getNav()
{
	$('header').load("./include/nav.html", function()
	{
		resize();
	});
}

function resize(){
	$.getScript("./script/js/nav.js").done(function()
	{
		resize();
	});
}

function getDashboard()
{
	$('#main').load("./include/dashboard.html", function()
	{
		$.getScript("./script/js/dashboard.js").done(function()
		{
			getLogin();
			getTeamSpeak();
			resize();
		});
	});
}

/*
 *function to display messages
 *@params:
 *	msg: Message to display
 *	type: (0, 1, 2)
 *				0: info
 *				1: warning
 *				2: error
 *	time: time for message to disappear (0/ null to dont disappear by it self)
*/
function promptMessage(msg, type, time)
{
	var msgBox = $('#msg-box');
	switch (type) {
		case 0:
			msgBox.css("background-color", "grey");
			msgBox.html("<h1>Info</h1>");
			break;
		case 1:
			msgBox.css("background-color", "yellow");
			msgBox.html("<h1>Warning</h1>");
			break;
		case 2:
			msgBox.css("background-color", "var(--error-color)");
			msgBox.html("<h1>Error</h1>");
			break;
		default:
			msgBox.css("background-color", "var(--error-color)");
			msgBox.html("<h1>Error</h1><p>That is kind of ironic! There occured an error while displaying an error! Please consider trying again!</p>");
			break;
	}
	msgBox.append("<p>" + msg + "</p>");

	msgBox.fadeIn(500);

	if(time > 0)
	{
		let i = setInterval(function(){msgBox.fadeOut(300);}, time);
	}
	else
	{
		msgBox.append("<a href='#' onclick='$(\"#msg-box\").fadeOut(300)' >Close</a>");
	}
}

function errorHandler(response)
{
	switch(response.status)
	{
		case "502":
			promptMessage(response.message, 2, 10000);
			console.error(response.errormsg);
		break;
		case "500":
			promptMessage(response.message, 2, 10000);
			console.error(response.errormsg);
		break;
		case "400":
			promptMessage(response.message, 2, 10000);
			console.error(response.errormsg);
		break;
		default: console.log(response.status + ": " + response.message + " (" + response.errormsg + ")");
	}
}

$(document).ready(function()
{
	getNav();
	getDashboard();
	resize();

	$(window).resize(function()
	{
		resize();
	});
});
