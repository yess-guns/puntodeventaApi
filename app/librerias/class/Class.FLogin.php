<?php

class FLogin
{
  function genKey($user)
  {
    $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890";
    $code = "";
    $fecha = date('Y-m-d');
    $hora = date('h:i:s');
    for ($i = 0; $i < 8; $i++) {
      $code .= $alphabeth[rand(0, strlen($alphabeth) - 1)];
    }
    //return $code.'&'.$user.'&'.$hora.'&'.$fecha;
    return $code . '/' . $fecha . '/' . $hora . '&' . base64_encode($user);
    //return $code;
  }
}
