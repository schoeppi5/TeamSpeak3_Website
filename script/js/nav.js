var slideSpeed = 150;

function resize()
{
	$('#nav-placeholder').css("height", $('nav').height());
	$('#main').css("min-height", $('body').height() - $('header').height() - $('footer').height());
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

$(document).ready(function()
{
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
