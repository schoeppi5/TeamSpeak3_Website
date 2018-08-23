function loadInfo()
{
  $.ajax({
		type : 'POST',
		url  : '/script/php/query_ts_info.php',
		success :  function(response) {
			response = $.parseJSON(response);
			if(response.status == "200")
			{
        if(response.server_status == "online")
        {
          $('#ts-name').html(response.server_name);
          $('#ts-status').html("Online");
          $('#ts-clients').html(response.server_clients + "/" + response.server_maxclients);
          $('#ts-ip').html(response.server_ip + ":" + response.server_port);
          $('#ts-ip').attr("href", "ts3server://" + response.server_ip + "?port=" + response.server_port);
          $('#ts-version').html(response.server_version);

          loadClients();
        }
        else {
          $('#ts-status').html("Offline");
        }
			}
			else
			{
				errorHandler(response);
        $('#ts-dashlet').hide();
        $('#profile-dashlet').hide();
			}
		}
	});
}

function loadClients()
{
  $.ajax({
    type : 'POST',
    url  : '/script/php/get_online_clients.php',
    success :  function(response) {
      response = $.parseJSON(response);
      if(response.status == "200")
      {
        $('#ts-dashlet-right').html("");
        $.each(response, function(i, obj) {
          if(obj.hasOwnProperty('client_name')){
            $('#ts-dashlet-right').append("<div class=\"ts-user\" onclick=\"pokeClient('" + obj.client_uid + "')\"><div class=\"ts-user-name left\">"
              + (obj.client_state >= 1 ? "<img src=\"/script/php/libs/ts3phpframework/images/viewericons/client_"
                + (obj.client_state > 1 ? "snd" : "mic") + "_muted.png\" />" : "")
              + obj.client_name + "</div><div class=\"ts-user-level right\">" + obj.client_power + "</div></div>");
          }
        });
        if($('#ts-dashlet-right').children().length === 0){
          $('#ts-dashlet-right').hide();
          $('#ts-dashlet-left').removeClass("left");
          $('#ts-dashlet-left').addClass("full");
          $('#ts-dashlet-left').css("border", "none");
        }
        else {
          $('#ts-dashlet-right').show();
          $('#ts-dashlet-left').addClass("left");
          $('#ts-dashlet-left').removeClass("full");
          $('#ts-dashlet-left').css("border", "border-right: .5px solid var(--accent-one);");
        }
      	resize();
        loaded();
        $('#ts-reload > button').html("Reload");
      }
      else
      {
        errorHandler(response);
      }
    }
  });
}

function pokeClient(uid){
  var msg = prompt("Enter Message:", "");
  $.ajax({
    type: 'POST',
    url: '/script/php/poke_client.php',
    data: {uid: uid, msg: msg},
    success: function(response){
      response = $.parseJSON(response);
      if(response.status !== "200"){
        errorHandler(response);
      }
    }
  })
}

function tsreload(){
  $('#ts-reload > button').html("<img src=\"/img/reload.svg\" style=\"width: 1rem; height: 1rem\"/>");
  loadInfo();
  $('#ts-viewer').html("");
  $('#ts-viewer').hide();
}

function getTsViewer(){
  $.ajax({
    url: "/script/php/get_ts_viewer.php",
    success: function(response){
      $('#ts-viewer').html(response);
      $('#ts-viewer').slideDown(250);
    }
  })
}

function toggleTsViewer(){
  var viewer = $('#ts-viewer');
  if(viewer.is(":hidden")){
    if(viewer.text().trim() == ""){
      getTsViewer();
    }
    else {
      viewer.slideDown(250);
    }
  }
  else {
    viewer.slideUp(250);
  }
}

function joinChannel(obj){
  $.ajax({
    url: "/script/php/get_channel_url_by_name.php",
    type: "POST",
    data: {"name": $(obj).text().trim()},
    success: function(response){
      response = $.parseJSON(response);
      window.open(response.message);
    }
  })
}
