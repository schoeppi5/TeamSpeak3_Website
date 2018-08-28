<?php
  include("./login_config.php");

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
                                      'QVRKU0grZkU=',
                                      '37.120.184.91',
                                      9987,
                                      10011,
                                      6,
                                      12,
                                      7
                                    )");

echo "Finished";
?>
