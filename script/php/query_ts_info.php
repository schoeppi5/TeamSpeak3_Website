<?php
	require_once("./libs/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
	include("./messageHandler.php");
	include("./libs/ts3_server_connection_helper.php");

  try
  {
		$ts3_VirtualServer = new ts3Server();
		if($ts3_VirtualServer->getServerConnection()){

			$res = new response("200", "Node info fetched");


	    $ts3_info = array("server_name" => $ts3_VirtualServer->getServerConnection()->virtualserver_name->toString(),
			"server_maxclients" => $ts3_VirtualServer->getServerConnection()->virtualserver_maxclients,
			"server_clients" => $ts3_VirtualServer->getServerConnection()->virtualserver_clientsonline - $ts3_VirtualServer->getServerConnection()->virtualserver_queryclientsonline,
			"server_ip" => $ts3_VirtualServer->getServerConnection()->getAdapterHost()->toString(),
			"server_port" => $ts3_VirtualServer->getServerConnection()->virtualserver_port,
			"server_version" => TeamSpeak3_Helper_Convert::version($ts3_VirtualServer->getServerConnection()->virtualserver_version)->toString(),
			"server_status" => $ts3_VirtualServer->getServerConnection()->virtualserver_status->toString());

			$res->mergeArray($ts3_info);
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
		$res = new response("500", "Internal Server Error");
		$res->addErrorMessage($e);
  }
  catch (Exception $e)
  {
		$res = new response("400", "Bad request");
		$res->addErrorMessage($e);
  }

  echo $res->getJSON();
?>
