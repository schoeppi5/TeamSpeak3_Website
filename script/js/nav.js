var slideSpeed = 150;

function resize()
{
	$('#nav-placeholder').css("height", $('nav').height());
	$('.container').css("height", $('body').height() - $('header').height());
	if($('.drop-btn').css('display') == "none")
	{
		$('.drop').show();
	}
}

$(document).ready(function()
{
	$('#login-con').load("/include/login.html", function()
	{
		$.getScript("/script/js/login.js").done(function()
		{
			rememberLogin();
		});
	});

	$('.drop-btn').click(function()
	{
		$('.hamburger').toggleClass("is-active");
		$('.drop').slideToggle(slideSpeed);
	});

	$('#login a').click(function()
	{
		$('#login-con').slideToggle(slideSpeed);
	});

	$('#lang').click(function()
	{
		$('#lang-form').slideToggle(slideSpeed);
	});
});
