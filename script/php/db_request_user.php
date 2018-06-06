<?php
  include("login_config.php");

  $response = "";

  if (isset($_COOKIE['userID'])) {
    $userID = $_COOKIE['userID'];

    $statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :id");
    $statement->execute(array('id' => $userID));
    $user = $statement->fetch();

    if($user !== false)
    {
      $response = array("status" => "200", "email" => $user["email"], "username" => $user["username"]);
    }
    else {
      $response = array('status' => "404", 'message' => "User not found!");
    }
  }
  else {
    $response = array('status' => '400', 'message' => 'No user logged in');
  }

  echo json_encode($response);
?>
