<?php
  include("./login_config.php");
  require_once("./libs/ts3_server_connection_helper.php");

  class user {
    public static function withId($id){
      global $pdo;
      $statement = $pdo->prepare("SELECT * FROM users WHERE uid = :id");
      $statement->execute(array("id" => $id));
      return $statement->fetch();
    }

    public static function withTsId($id){
      global $pdo;
      $statement = $pdo->prepare("SELECT * FROM users WHERE tsuid = :id");
      $statement->execute(array("id" => $id));
      return $statement->fetch();
    }

    public static function fetchTsUserWithId($id){
      $server = new ts3Server();
      $tsid = self::withId($id)["tsuid"];
      return $server->getServerConnection()->clientGetByDbId($server->getServerConnection()->clientFindDb($tsid, true)[0]);
    }

    public static function fetchTsUserWithTsId($id){
      $server = new ts3Server();
      return $server->getServerConnection()->clientGetByDbId($server->getServerConnection()->clientFindDb($id, true)[0]);      
    }
  }
?>
