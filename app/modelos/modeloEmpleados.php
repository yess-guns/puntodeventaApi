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

  public function getTipoEmpleado()
  {
    $tipoEmp = $this->db->select("tipoempleado",
      [
        "id_tipoEmpleado",
        "nombreTipoEmpleado(nombre)"
      ]
    );
    return $tipoEmp;
  }

  public function getEmpleados()
  {
    $empleados = $this->db->select("empleados",
      [
        "[><]tipoempleado" => ["id_tipoEmpleado" => "id_tipoEmpleado"]
      ],
      [
        "empleados.id_empleado",
        "empleados.nombreEmpleado",
        "empleados.apellidosEmpleado",
        "empleados.claveAcceso",
        "tipoempleado.id_tipoEmpleado",
        "tipoempleado.nombreTipoEmpleado(tipo)"
      ]
    );
    return $empleados;
  }

  public function nuevoEmpleado($form)
  {
    $insert = $this->db->insert("empleados",
    [
      "id_tipoEmpleado" => $form['tipo'],
      "nombreEmpleado" => $form['nombre'],
      "apellidosEmpleado" => $form['ape'],
      "claveAcceso" => $form['clave']
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }

  public function editEmpleado($form)
  {
    $update = $this->db->update("empleados",
      [
      "id_tipoEmpleado" => $form['tipo'],
      "nombreEmpleado" => $form['nombre'],
      "apellidosEmpleado" => $form['ape'],
      "claveAcceso" => $form['clave']
      ],
      [
        "id_empleado" => $form['id_empleado']
      ]
    );

    return $update->rowCount() === 1 ? true : false;
  }

  public function validClave($clave)
	{
    $res = $this->db->has("empleados", [
    	"AND" => [
    		"claveAcceso" => $clave
    	]
    ]);
    return $res;
  }
  
}
