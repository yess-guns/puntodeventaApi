<?php

class modeloMesas
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}
  
	public function getMesasVenta()
	{
    $data = $this->db->select("mesas",
      [
        "id_mesa",
        "id_venta",
        "numero"
      ],
      ["statusMesa" => 1]
    );
		return ($data) ? $data : [];
  }

  public function getMesasDisp()
	{
    $data = $this->db->select("mesas",
      [
        "id_mesa",
        "numero"
      ],
      ["id_venta" => 0]
    );
		return ($data) ? $data : [];
  }
  
}
