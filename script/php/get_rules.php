<?php
  include("./libs/parsedown/Parsedown.php");
  include("./messageHandler.php");

  if(isset($_POST) && !empty($_POST["lang"])){
    $rulesFile = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/rules/rules_".$_POST["lang"].".md");
    if($rulesFile !== false){
      $pd = new Parsedown();
      $res = new response("200", $pd->text($rulesFile));
    }
    else {
      $res = new response("404", "File not found");
    }
  }
  else {
    $res = new response("400", "No language given");
  }

  echo $res->getJSON();
?>
