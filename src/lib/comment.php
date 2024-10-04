<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
require_once(MY_ROOT_DB_LIB);

$server_method_type = strtoupper($_SERVER["REQUEST_METHOD"]);
$conn = my_db_conn();

try{
  if(strtoupper($server_method_type === "POST")){
    switch($_POST["action"]){
      case "insert":
        $arr_prepare=[
          "user_id" => $_POST["user_id"]
          ,"board_id" => $_POST["board_id"]
          ,"content" => $_POST["content"]
        ];
        insert_comment($conn, $arr_prepare);
        break;
      case "delete":
        $arr_prepare=[
          "comment_id" => $_POST["comment_id"]
        ];
        delete_comment($conn, $arr_prepare);
        break;
    }
  }
  else{
  
  }
}
catch(Throwable $th){
  echo $th->getMessage();
  exit;
}