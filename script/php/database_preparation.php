<?php
  include("login_config.php");
  include("./messageHandler.php");

  try{
    $pdo->beginTransaction();
    $pdo->exec("CREATE DATABASE IF NOT EXISTS teamspeak;");

    $pdo->exec("USE teamspeak;");

    $pdo->exec("DROP TABLE IF EXISTS admin;");
    $pdo->exec("DROP TABLE IF EXISTS users;");
    $pdo->exec("DROP TABLE IF EXISTS valid;");
    $pdo->exec("DROP TABLE IF EXISTS tsconfig;");
    $pdo->exec("DROP TABLE IF EXISTS gameserverconfig;");
    $pdo->exec("DROP TABLE IF EXISTS config;");

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

    $pdo->exec("CREATE TABLE IF NOT EXISTS tsconfig (
        username VARCHAR(50) NOT NULL,
        password VARCHAR(50) NOT NULL,
        host VARCHAR(100) NOT NULL,
        port INT(10) NOT NULL,
        queryport INT(10) NOT NULL,
        admingroup INT(3) NOT NULL,
        moderatorgroup INT(3) NOT NULL,
        membergroup INT(3) NOT NULL
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS gameserverconfig (
        host VARCHAR(100) NOT NULL,
        port INT(10) NOT NULL,
        name VARCHAR(100) NOT NULL,
        type INT(1) NOT NULL,
        version INT(2),
        uid VARCHAR(10) PRIMARY KEY
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS config (
        name VARCHAR(100) NOT NULL,
        author VARCHAR(100) NOT NULL,
        editor VARCHAR(100),
        icon LONGBLOB,
        version VARCHAR(10) NOT NULL
    );");

    $pdo->exec("INSERT INTO config (
      name,
      author,
      version
    ) VALUES (
      'TeamSpeak Website',
      'schoeppi5 (<a href=\"https://github.com/schoeppi5\">GitHub</a>)',
      '1.0'
    )");

    $statement = $pdo->prepare("
      INSERT INTO admin (username, password)
      VALUES ('admin', :passwd);");

    $passwd = password_hash("admin", PASSWORD_DEFAULT);

    $result = $statement->execute(array("passwd" => $passwd));

    $pdo->commit();

    $res = new response("200", "Database reset");
    echo $res->getJSON();
  }
  catch(PDOException $e)
  {
    $res = new response("500", "Internal server error");
    $res->addErrorMessage($e);
    echo $res->getJSON();
  }
 ?>
