$('#ts-config-form').submit(function(event)
{
	event.preventDefault();
}).validate({
	rules: {
			ts_username: {required: true},
			ts_host: {required: true},
			ts_port: {required: true, number: true},
			ts_queryport: {required: true, number: true},
			ts_admingroup: {required: true, number: true},
			ts_moderatorgroup: {required: true, number: true},
			ts_membergroup: {required: true, number: true}
	},
	messages: {
		ts_username: "Please enter a valid username",
		ts_host: "Please enter a valid hostaddress",
    ts_port: "Please enter a valid port",
		ts_queryport: "Please enter a valid queryport",
		ts_admingroup: "Please enter a valid admin group ID",
		ts_moderatorgroup: "Please enter a valid moderator group ID",
		ts_membergroup: "Please enter a valid member group ID"
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
        $('#ts_' + key).val(value);
      });
    }
  });
}

$(document).ready(function(){
  loadTsConfig();
});
