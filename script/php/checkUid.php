<?php
	include("./messageHandler.php");
	include("./libs/ts3_server_connection_helper.php");
	include("./libs/generate_key.php");

	if(!empty($_POST))
	{
		$uid = $_POST['uid'];
		try
		{
			$ts3_VirtualServer = new ts3Server();
			if($ts3_VirtualServer->getServerConnection()){

				$key = helper::getKey(10);

				$ts3_VirtualServer->getServerConnection()->clientGetByUid($uid)->poke("Authentication key: ".$key);

				$statement = $pdo->prepare("DELETE FROM valid WHERE tsuid = :uid");
				$statement->execute(array("uid" => $uid));
				$statement = $pdo->prepare("INSERT INTO valid (tsuid, code) VALUES (:uid, :key)");
				$statement->execute(array("uid" => $uid, "key" => $key));

				$res = new response("200", "UID validated");
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
				$res = new response("400", "Bad request");
				$res->addErrorMessage($e);
		}
	}
	else
	{
		$res = new response("400", "Bad request");
		$res->addErrorMessage("No request was submitted");
	}

	echo $res->getJSON();
?>
