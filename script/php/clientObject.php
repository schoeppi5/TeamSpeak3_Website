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

	echo $server->getError();

	if($server){
		$client = user::fetchTsUserWithId("mRpHpWQAzn");

		$power = "";
		foreach($client->memberOf() as $ts3_group)
		{
			if($ts3_group->getUniqueId() == $server->getServerConnection()->serverGroupGetById($server->getAdminGroup())->getUniqueId())
			{
				$power = "Admin";
				break;
			}
			elseif($ts3_group->getUniqueId() == $server->getServerConnection()->serverGroupGetById($server->getModeratorGroup())->getUniqueId())
			{
				$power = "Moderator";
				break;
			}
			elseif($ts3_group->getUniqueId() == $server->getServerConnection()->serverGroupGetById($server->getMemberGroup())->getUniqueId())
			{
				$power = "Dude";
				break;
			}
		}
		if($power == "")
		{
			$power = "Guest";
		}

		$clientinfo = array("client_name" => $client->client_nickname->toString(), "client_power" => $power, "client_uid" => $client->client_unique_identifier->toString());

		$res = new response("200", "Client queried successfully");
		$res->mergeArray($clientinfo);
	}
	else {
		$res = $server->getError();
	}

	print_r($res->getJSON());
	?>
</pre>
