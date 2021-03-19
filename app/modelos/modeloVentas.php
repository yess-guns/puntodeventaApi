<?php

class modeloVentas
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}
  
	public function newVenta($idEmpleado, $mesas, $comensales)
	{
    $fecha = date('Y-m-d');
    $hora = date("H:i:s");
    $insert = $this->db->insert("ventas",
    [
      "id_empleado" => $idEmpleado,
      "comensales" => $comensales,
      "fecha" => $fecha,
      "hora" => $hora
    ]);

    $idVenta = $this->db->id();

    if($insert->rowCount() === 1){
      foreach($mesas as $mesa){
        $update = $this->db->update("mesas",
          [
            "id_venta" => $idVenta
          ],
          [
            "id_mesa" => $mesa
          ]
        );
      }      
      return $update->rowCount() === 1 ? true : 0;

    }else{
      return false;
    }
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
