$('#server-config-form').submit(function(event){
  event.preventDefault();
}).validate({
	rules: {
			server_host: {required: true},
			server_port: {required: true, number: true},
			server_config_type: {required: true},
			minecraft_version: {required: function(element){
        return $('#server-config-type').value === "Minecraft-Server";
      }},
			server_rcon_password: {required: '#server_rcon:checked'}
	},
	messages: {
		server_host: "Please enter a valid hostaddress",
		server_port: "Please enter a valid port",
    server_config_type: "Please select a server type",
		minecraft_version: "Please enter a valid version",
		server_rcon_password: "Please enter a valid RCON password"
	},
	errorPlacement: function(error, element) {
		element.attr("placeholder", error.text());
	},
	submitHandler: function() {
    addServer();
	}
});

function addServer(){
  var data = $('#server-config-form').serialize();

  data += "&server_config_type="
  + ($('#server_config_type').value !== "Minecraft-Server" ? "2" : "1")
  + "&server_version=" + ($('#server_config_type').value === "Minecraft-Server" ? $('#server_version').value : "");

  $.ajax({
    type: "POST",
    url: "/script/php/add_game_server.php",
    data: data,
    success: function(response){
			console.log(response);
      response = $.parseJSON(response);
      if(response.status === "200"){
        promptMessage("Configuration saved!", 0, 2500);
      }
    }
  });
}

$(document).ready(function(){
  $('#server_config_type').change(function(){
    if(this.value === "Minecraft-Server"){
      $('#server_version').show();
    }
    else {
      $('#server_version').hide();
    }
  });
  $('#server_rcon').change(function(){
    $('#server_rcon_password').prop('disabled', function(i, v) { return !v; }).focus();
  });
});
