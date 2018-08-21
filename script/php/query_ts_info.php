<?php
	// include("./login_config.php");
	require_once("./libs/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
	include("./messageHandler.php");

	//This is only a temporary solution until the config wizard is implemented
	$config["ts"]["username"] 			= "ServerQuery";
	$config["ts"]["password"] 			= "ATJSH+fE";
	$config["ts"]["host"]				= "37.120.184.91";
	$config["ts"]["port"]				= "9987";
	$config["ts"]["queryport"]			= "10011";

  try
  {
    $connectionString = "serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]."#no_query_clients";

    $ts3_VirtualServer = TeamSpeak3::factory($connectionString);

		$res = new response("200", "Node info fetched");

    $ts3_info = array("server_name" => $ts3_VirtualServer->virtualserver_name->toString(), "server_maxclients" => $ts3_VirtualServer['virtualserver_maxclients'], "server_clients" => $ts3_VirtualServer['virtualserver_clientsonline'] - $ts3_VirtualServer['virtualserver_queryclientsonline'], "server_ip" => $ts3_VirtualServer->getAdapterHost()->toString(), "server_port" => $ts3_VirtualServer->virtualserver_port, "server_version" => TeamSpeak3_Helper_Convert::version($ts3_VirtualServer->virtualserver_version)->toString(), "server_status" => $ts3_VirtualServer->virtualserver_status->toString());

		$res->mergeArray($ts3_info);

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
