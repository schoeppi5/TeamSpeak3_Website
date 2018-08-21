<?php
	include("./login_config.php");
	require_once("./libs/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
	include("./messageHandler.php");

  $config["ts"]["username"] 			= "ServerQuery";
  $config["ts"]["password"] 			= "ATJSH+fE";
  $config["ts"]["host"]				= "37.120.184.91";
  $config["ts"]["port"]				= "9987";
  $config["ts"]["queryport"]			= "10011";
  $config["ts"]["adminGroupId"]		= "6";
  $config["ts"]["moderatorGroupId"]	= "12";
  $config["ts"]["memberGroupId"]		= "7";

  if(isset($_SESSION["uid"]))
  {
    $uid = $_SESSION["uid"];
    try
    {

      $connectionString = "serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]."#no_query_clients";

      $ts3_VirtualServer = TeamSpeak3::factory($connectionString);

  		$client = $ts3_VirtualServer->clientGetByUid($uid);

      $power = "";
      foreach($client->memberOf() as $ts3_group)
      {
        if($ts3_group->getUniqueId() == $ts3_VirtualServer->serverGroupGetById($config["ts"]["adminGroupId"])->getUniqueId())
        {
          $power = "Admin";
          break;
        }
        elseif($ts3_group->getUniqueId() == $ts3_VirtualServer->serverGroupGetById($config["ts"]["moderatorGroupId"])->getUniqueId())
        {
          $power = "Moderator";
          break;
        }
        elseif($ts3_group->getUniqueId() == $ts3_VirtualServer->serverGroupGetById($config["ts"]["memberGroupId"])->getUniqueId())
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
			$res = new response("400", "Bad request");
			$res->addErrorMessage($e);
    }
  }
  else {
		$res = new response("404", "No user logged in");
		$res->addErrorMessage("Either there was no cookie set or the set uid wasn't found in the database");
  }

  echo $res->getJSON();
?>
