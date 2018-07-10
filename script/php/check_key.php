<?php
	include("login_config.php");

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
  			$response = array("status" => "200", "message" => "Logged in");
      }
      else{
        $response = array("status" => "404", "message" => "Key not found");
      }

		}
		catch (TeamSpeak3_Adapter_ServerQuery_Exception $e)
		{
			$response = array("status" => "502", "message" => "Unable to connect to query!", "errormsg" => $e);
		}
		catch (TeamSpeak3_Exception $e)
		{
			$response = array("status" => "500", "message" => "Internal Server Error!", "errormsg" => $e);
		}
		catch (Exception $e)
		{
			$response = array("status" => "400", "message" => "Bad Request!", "errormsg" => $e);
		}
	}
	else
	{
		$response = array("status" => "400", "message" => "Bad Request!", "errormsg" => "No request was submitted!");
	}


	echo json_encode($response);

?>
