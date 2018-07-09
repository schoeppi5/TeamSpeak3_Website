var slideSpeed = 150;

function resize()
{
	$('#nav-placeholder').css("height", $('nav').height());
	$('#main').css("height", $('body').height() - $('header').height());
	if($('.drop-btn').css('display') == "none")
	{
		$('.drop').show();
	}
	if ($('#ts-dashlet-left').height() > $('#ts-dashlet-right').height()) {
		$('#ts-dashlet-right').height($('#ts-dashlet-left').height());
	} else {
		$('#ts-dashlet-left').height($('#ts-dashlet-right').height());
	}
}

$('nav').ready(function()
{
	$.getScript("/script/js/login.js").done(function()
	{
		rememberLogin();
	});

	$('.drop-btn').click(function()
	{
		$('.hamburger').toggleClass("is-active");
		$('.drop').slideToggle(slideSpeed);
	});

	$('#lang').click(function(evt)
	{
		$('#lang-form').slideToggle(slideSpeed);
		evt.stopImmediatePropagation();
	});
});
