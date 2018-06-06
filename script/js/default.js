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

$(document).ready(function()
{
	getNav();

	$(window).resize(function()
	{
		resize();
	});
});
