<?php
	include("login_config.php");
	include("./messageHandler.php");

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

  if(!empty($_POST) && isset($_POST["code"]) && isset($_POST["remember"]))
	{
		$key = $_POST["code"];
    if($_POST["remember"] == "on"){
      $remember = true;
    }
    else {
      $remember = false;
    }


		try
		{
			$statement = $pdo->prepare("SELECT tsuid FROM valid WHERE code = :key");
			$statement->execute(array("key" => $key));
      $resultset = $statement->fetch();
      $statement = $pdo->prepare("DELETE FROM valid WHERE code = :key");
			$statement->execute(array("key" => $key));

      if(isset($resultset["tsuid"])){
        if($remember == true){
          $statement = $pdo->prepare("DELETE FROM users WHERE tsuid = :uid");
          $statement->execute(array("uid" => $resultset["tsuid"]));
          $statement = $pdo->prepare("INSERT INTO users (tsuid, uid) VALUES (:uid, :code)");
          $code = rndKey(10);
    			$statement->execute(array("uid" => $resultset["tsuid"], "code" => $code));
          setcookie('uid', $code, time() + (365 * 24 * 60 * 60), "/");
        }
        $_SESSION["uid"] = $resultset["tsuid"];
				$res = new response("200", "Logged in");
      }
      else{
				$res = new response("404", "Key not found");
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
		$res = new response("502", "Bad request");
		$res->addErrorMessage("No request was submitted");
	}


	echo $res->getJSON();

?>
