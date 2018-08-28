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

				(isset($_SESSION["uid"]) ? $clientID = $_SESSION["uid"] : $clientID = user::withId($_COOKIE["uid"])["tsuid"]);

	      $power = user::getClientPowerDB($clientID);
				$name = user::getClientNameDB($clientID)["name"]->toString();

	      $clientinfo = array("client_name" => $name, "client_power" => $power, "client_uid" => $clientID);

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
