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
  + ($('#server_config_type').val() !== "Minecraft-Server" ? "1" : "2")
  + "&server_version=" + ($('#server_config_type').val() === "Minecraft-Server" ? $('#server_version').val() : "");

  console.log(data);

  $.ajax({
    type: "POST",
    url: "/script/php/add_game_server.php",
    data: data,
    success: function(response){
			console.log(response);
      response = $.parseJSON(response);
      if(response.status === "200"){
        promptMessage("Configuration saved!", 0, 2500);
        fetchGameServer();
      }
    }
  });
}

function fetchGameServer(){
  $.ajax({
    url: "/script/php/fetch_gameserver.php",
    success: function(response){
      response = $.parseJSON(response);
      $('#server-servers-tab').html("");
      $.each(response.servers, function(i, obj){
        console.log(obj);
        obj = $.parseJSON(obj);
        $('#server-servers-tab').append(formatServer(obj.serverinfo.name, obj.serverinfo.host,
                                                      obj.serverinfo.port, obj.serverinfo.player,
                                                      obj.serverinfo.maxplayer, obj.serverinfo.gamedesc, i,
                                                      (obj.serverinfo.connectlink !== null ? obj.serverinfo.connectlink : null)));
      });
    }
  });
}

function formatServer(name, host, port, player, maxplayer, gamedesc, uid, link = null){
  var element;

  element = "<div class=\"server-server-dashlet\" id=\"" + uid + "\">";
  element += "<span class=\"server-server-dashlet-caption\">" + name + "<button onclick=\"deleteServer('" + uid + "')\">Delete</button></span>";
  element += "<div class=\"server-row\"><span class=\"left\">Address:</span><span class=\"right\">" + (link !== null ? "<a href=\"" + link + "\">" + host + ":" + port + "</a>" : host + ":" + port) + "</span></div>";
  element += "<div class=\"server-row\"><span class=\"left\">Players:</span><span class=\"right\">" + player + "/" + maxplayer + "</span></div>";
  element += "<div class=\"server-row\"><span class=\"left\">Description:</span><span class=\"right\">" + gamedesc + "</span></div>";

  return element;
}

function deleteServer(uid){
  $.ajax({
    url: "/script/php/delete_server.php",
    type: "POST",
    data: {"uid": uid},
    success: function(response){
      promptMessage("Server deleted!", 0, 2500);
      fetchGameServer();
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
  fetchGameServer();
});
