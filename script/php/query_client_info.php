<?php
	include("./messageHandler.php");
	include("./libs/ts3_server_connection_helper.php");
	include("./libs/db_user_helper.php");

  if(isset($_SESSION["uid"]) || isset($_COOKIE["uid"]))
  {
    try
    {
			$ts3_VirtualServer = new ts3Server();
			if($ts3_VirtualServer->getServerConnection()){

				(isset($_SESSION["uid"]) ? $client = user::fetchTsUserWithTsId($_SESSION["uid"]) : $client = user::fetchTsUserWithId($_COOKIE["uid"]));

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

	      $clientinfo = array("client_name" => $client->client_nickname->toString(), "client_power" => $power, "client_uid" => $client->client_unique_identifier->toString());

				$res = new response("200", "Client queried successfully");
				$res->mergeArray($clientinfo);
			}
			else{
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
