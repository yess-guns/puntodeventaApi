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
      $pago = $this->modeloV->getPagoVentaC($idVenta);
      $dataPago = $pago == false ? null : $this->getTiposPagoVenta($pago);
      $resp['status'] = 'OK';
      $resp['res'] = ['platillos' => $ventaDatos, 'pago' => $dataPago];
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }
  public function getTiposPagoVenta($dataPago){
    $pEfectivo = $this->modeloV->getDataPagoEfectivo($dataPago['id_pago']);
    $pTarjeta = $this->modeloV->getDataPagoTarjeta($dataPago['id_pago']);
    $dataPago['pagoEf'] = $pEfectivo;
    $dataPago['pagoTj'] = $pTarjeta;
    return $dataPago;
  }
}
