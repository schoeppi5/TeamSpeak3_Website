<?php
  include("./libs/rcon/steam-condenser/steam-condenser.php");
  include("./libs/game_server_helper.php");

  error_reporting(E_ERROR);

  
  $server2 = new ServerHelper("37.120.184.91", 27016);
?>
<pre>
  <?php if($server2->isConnected()){
    print_r($server2->queryServerInfo());
    echo "test";
  }
  echo "Test"; ?>
</pre>
