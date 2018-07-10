<?php
	include("login_config.php");
	require_once("libs/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");

	//This is only a temporary solution until the config wizard is implemented
	$config["ts"]["username"] 			= "ServerQuery";
	$config["ts"]["password"] 			= "ATJSH+fE";
	$config["ts"]["host"]				= "suchtclub.de";
	$config["ts"]["port"]				= "9987";
	$config["ts"]["queryport"]			= "10011";

	function rndKey($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	if(!empty($_POST))
	{
		$uid = $_POST['uid'];
		try
		{
			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);

			$key = rndKey(10);

			$ts3_VirtualServer->clientGetByUid($uid)->poke("Authentication key: ".$key);

			$statement = $pdo->prepare("DELETE FROM valid WHERE tsuid = :uid");
			$statement->execute(array("uid" => $uid));
			$statement = $pdo->prepare("INSERT INTO valid (tsuid, code) VALUES (:uid, :key)");
			$statement->execute(array("uid" => $uid, "key" => $key));

			$response = array("status" => "200", "message" => "Uid validated!");

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
	else
	{
		$response = array("status" => "400", "message" => "Bad Request!", "errormsg" => "No request was submitted!");
	}


	echo json_encode($response);
?>
