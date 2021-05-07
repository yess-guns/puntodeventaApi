<?php

class modeloUsuarios
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}

  public function getPermisos()
  {
    $persimos = $this->db->select("permisos",
      [
        "id_permiso",
        "nombrePermiso(nombre)"
      ],
      [
        "id_permiso[!]" => 2
      ]
    );
    return $persimos;
  }

  public function getUsuarios()
  {
    $usuarios = $this->db->select("usuarios",
      [
        "[><]permisos" => ["id_permiso" => "id_permiso"]
      ],
      [
        "usuarios.id_usuario",
        "usuarios.email",
        "usuarios.estatus",
        "permisos.id_permiso",
        "permisos.nombrePermiso(permiso)"
      ]
    );
    return $usuarios;
  }

  public function changePass($id_usuario, $pass)
  {
    $update = $this->db->update("usuarios",
      [
      "contrasella" => md5($pass)
      ],
      [
        "id_usuario" => $id_usuario
      ]
    );

    return $update->rowCount() === 1 ? true : false;

  }

  public function changeStatus($id_usuario, $estatus)
  {
    $update = $this->db->update("usuarios",
      [
      "estatus" => $estatus
      ],
      [
        "id_usuario" => $id_usuario
      ]
    );

    return $update->rowCount() === 1 ? true : false;

  }

  public function validUser($email)
  {
    $res = $this->db->has("usuarios", [
    	"AND" => [
    		"email" => $email
    	]
    ]);
    return $res;
  }

  public function newUser($form)
  {
    $insert = $this->db->insert("usuarios",
    [
      "id_permiso" => $form['permiso'],
      "email" => $form['email'],
      "contrasella" => md5($form['pass'])
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }

  public function editEmail($email, $id_usuario)
  {
    $update = $this->db->update("usuarios",
      [
      "email" => $email
      ],
      [
        "id_usuario" => $id_usuario
      ]
    );

    return $update->rowCount() === 1 ? true : false;
  }

  public function editPermiso($permiso, $id_usuario)
  {
    $update = $this->db->update("usuarios",
      [
      "id_permiso" => $permiso
      ],
      [
        "id_usuario" => $id_usuario
      ]
    );

    return $update->rowCount() === 1 ? true : false;
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
