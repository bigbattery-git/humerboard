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

  function start_section(string $id, string $password){
    start_section($id, $password);
  }

  function throw_error(string $th = null){

    if(is_null($th)){
      throw new Exception("비정상적인 접근입니다. 다시 시도하세요");
    }

    else{
      throw new Exception($th);
    }

    return null;
  }

  function get_title_formet(string $title, int $cut_start_length = 16){

    $valid_len = 2;

    if(mb_strlen($title) > ($cut_start_length - $valid_len)){
      return mb_substr($title, 0, $cut_start_length)."...";
    }
    return $title;
  }