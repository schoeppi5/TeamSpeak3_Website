<?php
include("./libs/ts3_server_connection_helper.php");
include("./login_config.php");

echo $pdo->query("SELECT username FROM admin")->fetch()["username"];


 ?>
