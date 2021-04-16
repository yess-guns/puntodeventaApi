<?php

class modeloReportes
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}
  
	public function getVentasStatus($date)
	{
    $ventas = $this->db->select("ventas",
      [
        "[><]empleados" => ["id_empleado" => "id_empleado"]
      ],
      [
        "ventas.id_venta",
        "ventas.comensales",
        "ventas.fecha",
        "ventas.hora",
        "ventas.statusVenta",
        "empleados.nombreEmpleado(nombreM)",
        "empleados.apellidosEmpleado(apeM)",
      ],
      [
        "ventas.fecha" => $date
      ]
    );
		return $ventas;
  }

  public function getDatosVenta($idVEnta)
	{
    $data = $this->db->select("ventasdatos",
      [
        "[><]producto" => ["id_producto" => "id_producto"],
        "[><]empleados" => ["id_empleado" => "id_empleado"]
      ],
      [
        "ventasdatos.id_ventaDatos",
        "ventasdatos.comenzal",
        "ventasdatos.statusVentaDatos(status)",
        "producto.nombreProducto",
        "producto.precio",
        "empleado" => [
          "empleados.nombreEmpleado",
          "empleados.apellidosEmpleado"
        ]
      ],
      [
        "ventasdatos.id_venta" => $idVEnta
      ]
    );
		return ($data) ? $data : [];
  }

}
