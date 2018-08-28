loadTabControl();

function loadTabControl(uid = null){
  $.ajax({
    url: "/script/php/get_servers_names.php",
    success: function(response){
      try{
        response = $.parseJSON(response);
        $('#servers-tab-control').html("");
        $.each(response.servers, function(key, value){
          $('#servers-tab-control').append("<button onclick=\"loadServersInfo('" + key + "')\" id=\"" + key + "\">" + value + "</button>");
        });
        serverTabControlResize();
        if($('#servers-tab-control > button').length == 0){
          $('#servers-dashlet').hide();
        }
        if(uid == null){
          loadServersInfo($('#servers-tab-control > button:first').attr('id'));
        }else {
          loadServersInfo(uid);
        }
      }
      catch(e){
        $('#servers-dashlet').hide();
        console.log(e.message);
      }
      $('#servers-reload > button').html("Reload");
    }
  });
}

function loadServersInfo(uid){
  $.ajax({
    url: "/script/php/query_server_info.php",
    type: "POST",
    data: {"uid": uid},
    success: function(response){
      try{
        response = $.parseJSON(response);
        $('#servers-name').html(response.serverinfo.name);
        $('#servers-status').html("Online");
        $('#servers-clients').html(response.serverinfo.player + "/" + response.serverinfo.maxplayer);
        $('#servers-host').html((response.serverinfo.connectlink !== undefined ? "<a href=\"" + response.serverinfo.connectlink + "\" title=\"Join\">" + response.serverinfo.host + ":" + response.serverinfo.port + "</a>" : response.serverinfo.host + ":" + response.serverinfo.port));
        $('#servers-version').html(response.serverinfo.version);
        $('#servers-tab-control > button:not(#' + uid + ')').removeClass("activeTab");
        $('#' + uid).addClass("activeTab");
      }
      catch(e){
        $('#' + uid).html("Connection lost");
        console.log(e.message);
      }
    }
  });
}

function serversReload(){
  $('#servers-reload > button').html("<img src=\"/img/reload.svg\" style=\"width: 1rem; height: 1rem\"/>");
  selectedElement = $('.activeTab')[0];
  uid = $(selectedElement).attr("id");
  console.log(uid);
  loadTabControl(uid);
}
