function getNav()
{
	$('header').load("/include/nav.html", function()
	{
		$.getScript("/script/js/nav.js").done(function()
		{
			resize();
		});
	});
}

function getDashboard()
{
	$('.container-main').load("/include/dashboard.html", function()
	{
		$.getScript("/script/js/dashboard.js").done(function()
		{
			getLogin();
		});
	});
}

$(document).ready(function()
{
	getNav();
	getDashboard();

	$(window).resize(function()
	{
		resize();
	});
});
