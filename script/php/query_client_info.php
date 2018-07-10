<?php
	include("./login_config.php");
	require_once("./libs/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");

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

      $response = array("status" => "200", "message" => "Queried client successfully");
      $response = array_merge($response, $clientinfo);
    }
    catch (TeamSpeak3_Adapter_ServerQuery_Exception $e)
    {
      $response = array("status" => "502", "message" => "Unable to connect to query!", "errormsg" => $e->getMessage());
    }
    catch (TeamSpeak3_Exception $e)
    {
      $response = array("status" => "500", "message" => "Internal Server Error!", "errormsg" => $e->getMessage());
    }
    catch (Exception $e)
    {
      $response = array("status" => "400", "message" => "Bad Request!", "errormsg" => $e->getMessage());
    }
  }
  else {
    $response = array("status" => "404", "message" => "No User logged in!", "errormsg" => "No cookie was found");
  }

  echo json_encode($response);
?>
