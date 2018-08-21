<?php
	include("./messageHandler.php");
	include("./libs/ts3_server_connection_helper.php");
	include("./libs/db_user_helper.php");

  $server = new ts3Server();

?>
<pre>
	<?php
	// foreach ($server->getServerConnection()->clientList() as $client) {
	// 	print_r($client);
	// }

	print_r(user::fetchTsUserWithId("zaDTA3nj6R"));
	?>
</pre>
