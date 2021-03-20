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
      return $update->rowCount() === 1 ? $idVenta : 0;

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

  public function savePedido($idVenta, $pedido, $idEmpleado)
	{
    foreach($pedido as $pedi){
      $insert = $this->db->insert("ventasdatos",
        [
          "id_venta" => $idVenta,
          "id_producto" => $pedi['id_producto'],
          "id_empleado" => $idEmpleado,
          "comenzal" => $pedi['comensal']
        ]
      );
    }
    return $insert->rowCount() === 1 ? true : false;
  }

  public function getDatosVenta($idVEnta)
	{
    $data = $this->db->select("ventasdatos",
      [
        "[><]producto" => ["id_producto" => "id_producto"],
        "[><]empleados" => ["id_empleado" => "id_empleado"]
      ],
      [
        "ventasdatos.comenzal",
        "producto.nombreProducto",
        "empleado" => [
          "empleados.nombreEmpleado",
          "empleados.apellidosEmpleado"
        ]
      ],
      [
        "ventasdatos.id_venta" => $idVEnta,
        "ventasdatos.statusVentaDatos" => 1
      ]
    );
		return ($data) ? $data : [];
  }
  
}