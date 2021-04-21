<?php
class Reportes extends Controlador
{

	public function __construct()
	{
    $this->modelo = $this->modelos('modeloReportes');
    $this->modeloV = $this->modelos('modeloVentas');
    $this->resp = [
      'status' => 'err',
      'res' => 'Metodo invalido'
    ];
	}
	public function getVentasStatus(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $resp = [];
      $date = $_POST['date'];
      $ventas = $this->modelo->getVentasStatus($date);

      if(count($ventas) > 0){
        $resp['status'] = 'OK';
        $resp['dataV'] = $ventas;
      }else{
        $resp['status'] = 'error';
      }
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function getDatosVenta($idVenta){
		$resp = [
      'status' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $ventaDatos = $this->modelo->getDatosVenta($idVenta);
      //validar si ya tiene pago
      $dataPago = $this->getDataPagoByVenta($idVenta);
      $resp['status'] = 'OK';
      $resp['res'] = ['platillos' => $ventaDatos, 'pago' => $dataPago];
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }
  public function getDataPagoByVenta($idVenta){
    $pago = $this->modeloV->getPagoVentaC($idVenta);
    $dataPago = $pago == false ? null : $this->getTiposPagoVenta($pago);
    return $dataPago;
  }

  public function getTiposPagoVenta($dataPago){
    $pEfectivo = $this->modeloV->getDataPagoEfectivo($dataPago['id_pago']);
    $pTarjeta = $this->modeloV->getDataPagoTarjeta($dataPago['id_pago']);
    $dataPago['pagoEf'] = $pEfectivo;
    $dataPago['pagoTj'] = $pTarjeta;
    return $dataPago;
  }

  public function reporteVentasByDay(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $resp = [];
      $date = $_POST['date'];
      $ventas = $this->modelo->getVentaByDay($date);

      if(count($ventas) == 0){
        $resp['status'] = 'error';
      }else{
        $reporteVenta = $this->dataVentaReport($ventas);
        $resp['status'] = 'OK';
        $resp['dataV'] = $reporteVenta[0];
        $resp['totales'] = $reporteVenta[1];
      }

      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function reporteVentasByMonth(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $resp = [];
      $date = $_POST['date'];
      $ventas = $this->modelo->getVentaByMonth($date);

      if(count($ventas) == 0){
        $resp['status'] = 'error';
      }else{
        $reporteVenta = $this->dataVentaReport($ventas);
        $resp['status'] = 'OK';
        $resp['dataV'] = $reporteVenta[0];
        $resp['totales'] = $reporteVenta[1];
      }

      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function dataVentaReport($ventas){
    $montoTotal = 0;
    $montoEfec = 0;
    $montoTarj = 0;
    $Tcomensales = 0;
    foreach($ventas as $key => $venta){
      $dataPago = $this->getDataPagoByVenta($venta['id_venta']);
      $efectivo = $dataPago['pagoEf'] == null ? "0.00" : $dataPago['pagoEf']['monto'];
      $tarjeta = $dataPago['pagoTj'] == null ? "0.00" : $dataPago['pagoTj']['monto'];
      $comensales = intVal($venta['comensales']);

      $montoTotal += floatVal($dataPago['total']);
      $montoEfec += floatVal($efectivo);
      $montoTarj += floatVal($tarjeta);
      $Tcomensales += $comensales;
      $ventas[$key]['pago'] = $dataPago;
    }
    $montoTotal = [
      'total' => number_format($montoTotal, 2, '.', ''),
      'efectivo' => number_format($montoEfec, 2, '.', ''),
      'tarjeta' => number_format($montoTarj, 2, '.', ''),
      'comensales' => $Tcomensales
    ];
    return [$ventas, $montoTotal];
  }
}
