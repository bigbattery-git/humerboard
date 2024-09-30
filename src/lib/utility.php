<?php

  function get_date_formet(string $date){

    $today = date("Y-m-d");
    $explode = explode(" ", $date);

    if($today === $explode[0]){
      return $explode[1];
    }

    else{
      return $explode[0];
    }
  }

  function is_logined(string $id = null, string $password = null){

    if(is_null($id) || is_null($password)){
      return false;
    }

    return true;
  }

  function start_section(string $id, string $password){
    start_section($id, $password);
  }
?>