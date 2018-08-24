function getRules(lang){

  console.log(lang);

  $.ajax({
    type: "POST",
    url: "/script/php/get_rules.php",
    data: {"lang": lang},
    success: function(response){
      console.log(response);
      response = $.parseJSON(response);
      loaded();
      $('#rules-container').html(response.message);
    }
  });
}

$(document).ready(function(){
  getRules("en");
});
