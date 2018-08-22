$('#common-config-form').submit(function(event)
{
	event.preventDefault();
}).validate({
	rules: {
			username: {required: true},
			password: {required: true}
	},
	messages: {
		username: "Please enter a valid username",
		password: "Please enter a valid password"
	},
	errorPlacement: function(error, element) {
		element.attr("placeholder", error.text());
	},
	submitHandler: function() {
		saveCommonConfig();
	}
});

function saveCommonConfig(){
  var data = $('#common-config-form').serialize();

  $.ajax({
    type: "POST",
    url: "/script/php/save_common_config.php",
    data: data,
    success: function(response){
      response = $.parseJSON(response);
      if(response.status == "200"){
        promptMessage("Configuration saved!", 0, 2500);
      }
    }
  });
}

function loadCommonConfig(){
  $.ajax({
    url: "/script/php/load_common_config.php",
    success: function(response){
      response = $.parseJSON(response);
      if(response.status === "200")
      $.each(response.common, function(key, value) {
        $('#common-' + key).val(value);
      });
    }
  });
}

$(document).ready(function(){
  loadCommonConfig();
});
