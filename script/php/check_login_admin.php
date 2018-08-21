<?php
  include("login_config.php");
	include("./messageHandler.php");

  if(isset($_POST["username"]) && isset($_POST["passwd"]))
  {
    $username = $_POST["username"];
    $password = $_POST["passwd"];

    try{
      $statement = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
      $statement->execute(array("username" => $username));
      $user = $statement->fetch();

      if($user !== false){
        if(password_verify($password, $user['password'])){
          $res = new response("200", "Logged in");
        }
        else {
          $res = new response("403", "Access denied");
        }
      }
      else {
        $res = new response("404", "Username not found");
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

  echo $res->getJSON();
 ?>
