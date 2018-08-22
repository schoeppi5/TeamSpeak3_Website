$('#ts-config-form').submit(function(event)
{
	event.preventDefault();
}).validate({
	rules: {
			username: {required: true},
			password: {required: true},
			host: {required: true},
			port: {required: true, number: true},
			queryport: {required: true, number: true},
			admingroup: {required: true, number: true},
			moderatorgroup: {required: true, number: true},
			membergroup: {required: true, number: true}
	},
	messages: {
		username: "Please enter a valid username",
		password: "Please enter a valid password",
		host: "Please enter a valid hostaddress",
    port: "Please enter a valid port",
		queryport: "Please enter a valid queryport",
		admingroup: "Please enter a valid admin group ID",
		moderatorgroup: "Please enter a valid moderator group ID",
		membergroup: "Please enter a valid member group ID"
	},
	errorPlacement: function(error, element) {
		element.attr("placeholder", error.text());
	},
	submitHandler: function() {
		saveTsConfig();
	}
});

function saveTsConfig(){
  var data = $('#ts-config-form').serialize();

  $.ajax({
    type: "POST",
    url: "/script/php/save_ts_config.php",
    data: data,
    success: function(response){
      response = $.parseJSON(response);
      if(response.status == "200"){
        promptMessage("Configuration saved!", 0, 2500);
      }
    }
  });
}

function loadTsConfig(){
  $.ajax({
    url: "/script/php/load_ts_config.php",
    success: function(response){
      response = $.parseJSON(response);
      if(response.status === "200")
      $.each(response.ts, function(key, value) {
        $('#ts-' + key).val(value);
      });
    }
  });
}

$(document).ready(function(){
  loadTsConfig();
});
