$(document).ready(function()
{
  $('.circle-plus').click(function()
  {
    $(this).toggleClass('opened');
    $('.' + $(this).parent().attr("class") + '.slider').slideToggle(500);
  });
});
