<?php
  include("login_config.php");
	include("./messageHandler.php");

  $response = "";

  if (isset($_COOKIE['userID'])) {
    $userID = $_COOKIE['userID'];

    $statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :id");
    $statement->execute(array('id' => $userID));
    $user = $statement->fetch();

    if($user !== false)
    {
      $res = new response("200", "User fetched");
      $res->mergeArray(array("email" => $user["email"], "username" => $user["username"]));
    }
    else {
      $res = new response("404", "User not found");
    }
  }
  else {
    $res = new response("404", "No user logged in");
  }

  echo $res->getJSON();
?>
