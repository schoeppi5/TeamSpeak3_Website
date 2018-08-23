<?php
  include("./libs/ts3_server_connection_helper.php");

  $server = new ts3Server();
  if($server->getServerConnection())
  {
    echo $server->getServerViewer();
  }
?>
<script>
  $(document).ready(function(){
    $('.prefix').remove();
    $('.suffix').remove();
    $('.corpus > img').remove();
    $('.suffix.spacer').remove();
    $('.spacer').each(function(){
      if($(this).text() == "" || $(this).text() == " "){
        $(this).remove();
      }
    });
    $('.server').replaceWith('<h1 class="ts-viewer-server">' + $('.server').find(".corpus").text() + '</h1>');
    $('.spacer').each(function(){
      $(this).replaceWith('<h3 class="ts-viewer-spacer">' + $(this).find(".corpus").text() + '</h3>');
    });
    $('.channel').each(function(){
      $(this).replaceWith('<span class="ts-viewer-channel" onclick="joinChannel(this)">' + $(this).find(".corpus").text() + '</span>');
    });
    $('.client').each(function(){
      $(this).replaceWith('<span class="ts-viewer-client">' + $(this).find(".corpus").text() + "</span>");
    });
  });
</script>
