<?php
  include("login_config.php");

  try{
    $statement = $pdo->exec("
      CREATE DATABASE IF NOT EXISTS teamspeak;

      DROP TABLE IF EXISTS admin;
      DROP TABLE IF EXISTS users;

      CREATE TABLE IF NOT EXISTS admin (
        username VARCHAR(20) PRIMARY KEY,
        password VARCHAR(100)
      );

      CREATE TABLE IF NOT EXISTS users (
        tsuid VARCHAR(30) NOT NULL,
        uid VARCHAR(20) PRIMARY KEY
      );
    ");

    $statement = $pdo->prepare("
      INSERT INTO admin (username, password)
      VALUES ('admin', :passwd)");

    $passwd = password_hash("admin", PASSWORD_DEFAULT);

    $result = $statement->execute(array("passwd" => $passwd));

    echo "Success";
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
 ?>
