<?php
  include("login_config.php");

  try{
    $pdo->beginTransaction();
    $pdo->exec("CREATE DATABASE IF NOT EXISTS teamspeak;");

    $pdo->exec("USE teamspeak;");

    $pdo->exec("DROP TABLE IF EXISTS admin;");
    $pdo->exec("DROP TABLE IF EXISTS users;");
    $pdo->exec("DROP TABLE IF EXISTS valid;");

    $pdo->exec("CREATE TABLE IF NOT EXISTS admin (
        username VARCHAR(20) PRIMARY KEY,
        password VARCHAR(100)
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        tsuid VARCHAR(30) NOT NULL,
        uid VARCHAR(20) PRIMARY KEY
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS valid (
        tsuid VARCHAR(30) PRIMARY KEY,
        code VARCHAR(10) NOT NULL
    );");

    $statement = $pdo->prepare("
      INSERT INTO admin (username, password)
      VALUES ('admin', :passwd);");

    $passwd = password_hash("admin", PASSWORD_DEFAULT);

    $result = $statement->execute(array("passwd" => $passwd));

    $pdo->commit();
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
 ?>
