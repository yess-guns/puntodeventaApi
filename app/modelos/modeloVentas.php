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
        "ventasdatos.id_ventaDatos",
        "ventasdatos.comenzal",
        "producto.nombreProducto",
        "producto.precio",
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

  public function comensalesVenta($idVenta)
	{
    $comensales = $this->db->get("ventas",
      [
        "comensales"
      ],
      [
        "id_venta" => $idVenta
      ]
    );
		return $comensales;
  }
  public function getProductosDistinct($idVEnta)
	{
    $platiDistinct = $this->db->query(
      "SELECT DISTINCT id_producto FROM ventasdatos
      WHERE id_venta = $idVEnta AND statusVentaDatos = 1"
    )->fetchAll();
    return $platiDistinct;
  }
  public function getPlatilloVenta($idVEnta, $idProducto)
	{
    $data = $this->db->select("ventasdatos",
      [
        "[><]producto" => ["id_producto" => "id_producto"]
      ],
      [
        "producto.nombreProducto",
        "producto.precio"
      ],
      [
        "ventasdatos.id_venta" => $idVEnta,
        "ventasdatos.id_producto" => $idProducto,
        "ventasdatos.statusVentaDatos" => 1
      ]
    );
		return ($data) ? $data : [];
  }
  public function pay($idVenta, $idEmpleado, $precioTotal, $pago)
	{
    $fechaAct = date("Y-m-d");
    $horaAct = date("H:i:s");

    $insert = $this->db->insert("pagos",
      [
        "id_venta" => $idVenta,
        "id_empleado" => $idEmpleado,
        "total" => $precioTotal,
        "fechaPago" => $fechaAct,
        "horaPago" => $horaAct
      ]
    );
    if($insert->rowCount() === 1){
      $idPago = $this->db->id();
      $pago['efectivo']['status'] == true ? $this->pagoEfectivo($idPago, $pago['efectivo']) : '';
      $pago['tarjetaCD']['status'] == true ? $this->pagoTarjetaCD($idPago, $pago['tarjetaCD']) : '';
      return $idPago;
    }else{
      return false;
    }
  }

  public function pagoEfectivo($idPago, $pago){
    $insert = $this->db->insert("pagoefectivo",
      [
        "id_pago" => $idPago,
        "monto" => $pago['monto'],
        "propina" => $pago['propina'],
        "factura" => $pago['factura']
      ]
    );
  }
  public function pagoTarjetaCD($idPago, $pago){
    $insert = $this->db->insert("pagotarjetacd",
      [
        "id_pago" => $idPago,
        "monto" => $pago['monto'],
        "id_tipoTarjeta" => $pago['tipoT'],
        "id_tipoTAceptacion" => $pago['tipoA'],
        "numTarjeta" => $pago['numTarjeta'],
        "cvc" => $pago['cvc'],
        "bouche" => $pago['bouche'],
        "propina" => $pago['propina'],
        "factura" => $pago['factura']
      ]
    );
  }

  public function getdataPago($idPago){
    $data = $this->db->get("pagos",
      [
        "[><]empleados" => ["id_empleado" => "id_empleado"]
      ],
      [
        "pagos.id_pago",
        "pagos.id_pago(folio)",
        "pagos.total",
        "pagos.fechaPago(fecha)",
        "pagos.horaPago(hora)",
        "cajero" => [
          "empleados.nombreEmpleado(nombre)",
          "empleados.apellidosEmpleado(apellidos)"
        ]
      ],
      [
        "id_pago" => $idPago
      ]
    );
		return $data;
  }
  
  public function getDataPagoEfectivo($idPago){
    $data = $this->db->get("pagoefectivo",
      [
        "monto",
        "propina"
      ],
      [
        "id_pago" => $idPago,
        "statusPagoEf" => 1
      ]
    );
		return $data;
  }

  public function getDataPagoTarjeta($idPago){
    $data = $this->db->get("pagotarjetacd",
      [
        "[><]tipotarjeta" => ["id_tipoTarjeta" => "id_tipoTarjeta"],
        "[><]tipotaceptacion" => ["id_tipoTAceptacion" => "id_tipoTAceptacion"],
      ],
      [
        "pagotarjetacd.monto",
        "pagotarjetacd.propina",
        "tipotarjeta.nombreTipoT(tipo)",
        "tipotaceptacion.nombreTacpetacion(aceptacion)"
      ],
      [
        "pagotarjetacd.id_pago" => $idPago,
        "pagotarjetacd.statusPagoT" => 1
      ]
    );
		return $data;
  }

  public function getPagoVentaC($idVenta){
    $data = $this->db->get("pagos",
      [
        "[><]empleados" => ["id_empleado" => "id_empleado"]
      ],
      [
        "pagos.id_pago",
        "pagos.id_pago(folio)",
        "pagos.total",
        "pagos.fechaPago(fecha)",
        "pagos.horaPago(hora)",
        "cajero" => [
          "empleados.nombreEmpleado(nombre)",
          "empleados.apellidosEmpleado(apellidos)"
        ]
      ],
      [
        "id_venta" => $idVenta
      ]
    );
		return $data;
  }

  public function getMeseroVenta($idVenta){
    $data = $this->db->get("ventas",
      [
        "[><]empleados" => ["id_empleado" => "id_empleado"]
      ],
      [
        "empleados.nombreEmpleado(nombre)",
        "empleados.apellidosEmpleado(apellidos)"
      ],
      [
        "ventas.id_venta" => $idVenta
      ]
    );
		return $data;
  }

  public function validPagoV($idVenta){
    $data = $this->db->has("pagos",
      [
        "id_venta" => $idVenta
      ]
    );
		return $data;
  }

  public function finVenta($idVenta){//venta Finalizada
    $update = $this->db->update("ventas",
      [
        "statusVenta" => 0
      ],
      [
        "id_venta" => $idVenta
      ]
    );
    $this->finMesaVenta($idVenta);
    return $update->rowCount() === 1 ? true : false;
  }

  public function finMesaVenta($idVenta){
    $updateM = $this->db->update("mesas",
      [
        "id_venta" => 0
      ],
      [
        "id_venta" => $idVenta
      ]
    );
  }

  public function cancelarVenta($idVenta, $idEmpleado){//venta Cancelada
    $update = $this->db->update("ventas",
      [
        "statusVenta" => 2
      ],
      [
        "id_venta" => $idVenta
      ]
    );
    $this->finMesaVenta($idVenta);
    $this->ventaCancelada($idVenta, $idEmpleado);
    return $update->rowCount() === 1 ? true : false;
  }

  public function ventaCancelada($idVenta, $idEmpleado){
    $fecha = date('Y-m-d');
    $hora = date("H:i:s");
    $insert = $this->db->insert("ventaCancelada",
    [
      "id_venta" => $idVenta,
      "id_empleado" => $idEmpleado,
      "fechaC" => $fecha,
      "horaC" => $hora
    ]);
  }

  public function cancelarProducto($id_ventaDatos){//cancelar producto
    $update = $this->db->update("ventasdatos",
      [
        "statusVentaDatos" => 2
      ],
      [
        "id_ventaDatos" => $id_ventaDatos
      ]
    );
    return $update->rowCount() === 1 ? true : false;
  }
}