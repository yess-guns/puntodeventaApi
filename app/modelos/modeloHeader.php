<?php

class modeloHeader
{
  private $db;

  public function __construct()
  {
    $db = new Conexion();
    $this->db = $db->conn();
  }
  public function validToken($token)
  {
    $datas = $this->db->select("ingreso", [
      "key"
    ], [
      "key" => $token,
      "estatus" => 1
    ]);
    return ($datas) ? true : false;
  }
}
