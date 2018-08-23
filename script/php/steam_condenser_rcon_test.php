<?php
  include("./libs/rcon/steam-condenser/steam-condenser.php");

  error_reporting(E_ERROR);

  $server = new SourceServer("37.120.184.91", 27016);
  $server->initialize();
?>
<pre>
  <?php print_r($server->getServerInfo()); ?>
</pre>
<?php
  try{
    $server->rconAuth('elefanten1');
    echo $server->rconExec("say hi");
  }
  catch(RCONNoAuthException $e) {
    trigger_error('Could not authenticate with the game server.',
    E_USER_ERROR);
  }
  catch(Exception $e){
    echo "Test";
  }
?>
