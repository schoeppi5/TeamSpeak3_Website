<?php
  include("login_config.php");

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
      $response = array("status" => "404", "message" => "User not found", "errormsg" => $e->getMessage());
    }
  }
  else {
    $response = array("status" => "400", "message" => "Bad Request!", "errormsg" => "No parameters recieved");
  }
 ?>
