<?php
  include("./login_config.php");

  //password needs to be Base64 encoded

  $pdo->exec("INSERT INTO tsconfig (
                                      username,
                                      password,
                                      host,
                                      port,
                                      queryport,
                                      admingroup,
                                      moderatorgroup,
                                      membergroup)
                                    VALUES (
                                      'ServerQuery',
                                      '',
                                      '37.120.184.91',
                                      9987,
                                      10011,
                                      6,
                                      12,
                                      7
                                    )");

echo "Finished";
?>
