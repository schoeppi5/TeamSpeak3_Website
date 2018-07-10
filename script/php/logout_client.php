<?php
  include("login_config.php");

  if(isset($_COOKIE["uid"])){
    $uid = $_COOKIE["uid"];

    setcookie('uid', null, -1, "/");
    session_destroy();

    try
    {
      echo $uid;
      $statement = $pdo->prepare("DELETE FROM users WHERE uid = :uid");
      $statement->execute(array("uid" => $uid));
    }
		catch (Exception $e)
		{
			$response = array("status" => "500", "message" => "Internal server error", "errormsg" => $e->getMessage());
		}
    $response = array("status" => "200", "message" => "User logged out");
  }
  else {
    $response = array("status" => "404", "message" => "User not found", "errormsg" => "No cookie found");
  }

  echo json_encode($response);
?>
