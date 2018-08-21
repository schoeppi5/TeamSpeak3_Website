<?php
  include("login_config.php");
	include("./messageHandler.php");

  if(isset($_COOKIE["uid"])){
    $uid = $_COOKIE["uid"];

    setcookie('uid', null, -1, "/");
    session_destroy();

    try
    {
      $statement = $pdo->prepare("DELETE FROM users WHERE uid = :uid");
      $statement->execute(array("uid" => $uid));
      $res = new response("200", "User logged out");
    }
		catch (Exception $e)
		{
      $res = new response("500", "Internal server error");
      $res->addErrorMessage($e);
		}
  }
  else {
    $res = new response("404", "User not found");
    $res->addErrorMessage("Either there was no cookie set or the set uid wasn't found in the database");
  }

  echo $res->getJSON();
?>
