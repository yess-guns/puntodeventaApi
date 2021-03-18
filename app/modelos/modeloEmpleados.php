<?php

class modeloEmpleados
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}
  
	public function validEmpleado($clave, $tipoEmpleado)
	{
    $valid = $this->db->has("empleados",
      [
        "[><]tipoempleado" => ["id_tipoEmpleado" => "id_tipoEmpleado"]
      ],
      [
			"AND" => [
        "empleados.claveAcceso" => $clave,
        "tipoempleado.nombreTipoEmpleado" => $tipoEmpleado
			]
    ]);
    if($valid){
      $data = $this->db->get("empleados",
        [
          "[><]tipoempleado" => ["id_tipoEmpleado" => "id_tipoEmpleado"]
        ],
        [
          "empleados.id_empleado",
          "empleados.nombreEmpleado",
          "empleados.apellidosEmpleado",
          "tipoempleado.nombreTipoEmpleado"
        ],
        [
          "claveAcceso" => $clave
        ]
      );
		  return $data;
    }else{
      return false;
    }
  }
  
}
