<?php
  include("login_config.php");
	include("./messageHandler.php");

  if(isset($_POST["username"]) && isset($_POST["password"]))
  {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try{
      $statement = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
      $resultset = $statement->execute(array("username" => $username));
      $user = $resultset->fetch();

      if($user !== false){

      }
    }
    catch(PDOException $e)
    {
      $res = new response("404", "User not found");
      $res->addErrorMessage($e);
    }
  }
  else {
    $res = new response("400", "Bad Request");
    $res->addErrorMessage("No parameters submitted");
  }
 ?>
