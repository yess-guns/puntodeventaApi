<?php

class modeloTarjetas
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}
  
	public function getTipos()
	{
    $data = $this->db->select("tipotarjeta",
      "*",
      ["status" => 1]
    );
		return $data;
  }

  public function getAceptacion()
	{
    $data = $this->db->select("tipotaceptacion",
      "*",
      ["status" => 1]
    );
		return $data;
  }

}
