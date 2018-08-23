<?php
include("./libs/ts3_server_connection_helper.php");

$server = new ts3Server();
 ?>
<pre>
  <?php print_r($server->getChannelByName("Olymp")->cid); ?>
</pre>
