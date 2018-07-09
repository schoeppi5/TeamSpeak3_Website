<?php
  include("login_config.php");

  try{
    $pdo->beginTransaction();
    $statement = $pdo->exec("CREATE DATABASE IF NOT EXISTS teamspeak;");

    $statement = $pdo->exec("DROP TABLE IF EXISTS admin;");
    $statement = $pdo->exec("DROP TABLE IF EXISTS users;");

    $statement = $pdo->exec("CREATE TABLE IF NOT EXISTS admin (
        username VARCHAR(20) PRIMARY KEY,
        password VARCHAR(100)
    );");

    $statement = $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        tsuid VARCHAR(30) NOT NULL,
        uid VARCHAR(20) PRIMARY KEY
    );");

    // $statement = $pdo->prepare("
    //   INSERT INTO admin (username, password)
    //   VALUES ('admin', :passwd);");
    //
    // $passwd = password_hash("admin", PASSWORD_DEFAULT);
    //
    // $result = $statement->execute(array("passwd" => $passwd));

    $pdo->commit();

    $statement = $pdo->prepare("SELECT * FROM admin;");

    $statement->execute();

    echo $statement->fetch();

    echo "Success";
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
 ?>
