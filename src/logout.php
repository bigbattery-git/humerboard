<?php
session_start();

unset($_SESSION["id"]);

session_destroy();

$referer = isset($_POST["referer"]) ? $_POST["referer"] : "index.php";

if(strstr($referer, "joincomplete")|| strstr($referer, "joinmembership")){
  $referer = "index.php";
}

header("Location: ".$referer);
?>