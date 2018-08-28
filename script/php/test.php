<?php
include("./libs/ts3_server_connection_helper.php");
include("./login_config.php");
include("./libs/generate_key.php");
include("./libs/db_user_helper.php");

echo "<pre>";
print_r(user::getClientNameDB("dN7aM5tzpEaAhV2nEe5XIEoYINU=")["name"]->toString());
echo "</pre>";
 ?>
