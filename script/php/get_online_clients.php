<?php
	include("./messageHandler.php");
	include("./libs/ts3_server_connection_helper.php");

  try
  {
		$ts3_VirtualServer = new ts3Server();
    if($ts3_VirtualServer->getServerConnection()){
			$res = new response("200", "Queried clients successfully");

			$clients = array();

	    foreach ($ts3_VirtualServer->getServerConnection()->clientList() as $client)
	    {
	      $power = "";
	      foreach($client->memberOf() as $ts3_group)
	      {
	        if($ts3_group->getUniqueId() == $ts3_VirtualServer->getServerConnection()->serverGroupGetById($ts3_VirtualServer->getAdminGroup())->getUniqueId())
	        {
	          $power = "Admin";
	          break;
	        }
	        elseif($ts3_group->getUniqueId() == $ts3_VirtualServer->getServerConnection()->serverGroupGetById($ts3_VirtualServer->getModeratorGroup())->getUniqueId())
	        {
	          $power = "Moderator";
	          break;
	        }
	        elseif($ts3_group->getUniqueId() == $ts3_VirtualServer->getServerConnection()->serverGroupGetById($ts3_VirtualServer->getMemberGroup())->getUniqueId())
	        {
	          $power = "Dude";
	          break;
	        }
	      }
	      if($power == "")
	      {
	        $power = "Guest";
	      }
				$state = 0 + $client->client_input_muted + ($client->client_output_muted == 1 ? 2 : 0);

	      $clients = array_merge($clients, array(array("client_name" => $client->client_nickname->toString(), "client_power" => $power, "client_uid" => $client->client_unique_identifier->toString(), "client_state" => $state)));
	    }

			$res->mergeArray($clients);
		}
		else {
			$res = $ts3_VirtualServer->getError();
		}
  }
  catch (TeamSpeak3_Adapter_ServerQuery_Exception $e)
  {
		$res = new response("502", "Unable to connect to query");
		$res->addErrorMessage($e);
  }
  catch (TeamSpeak3_Exception $e)
  {
		$res = new response("500", "Internal server error");
		$res->addErrorMessage($e);
  }
  catch (Exception $e)
  {
		$res = new response("400", "Bad Request");
		$res->addErrorMessage($e);
  }

  echo $res->getJSON();
?>
