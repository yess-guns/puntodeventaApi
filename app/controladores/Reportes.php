<?php
class Reportes extends Controlador
{

	public function __construct()
	{
    $this->modelo = $this->modelos('modeloReportes');
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
      $resp['status'] = 'OK';
      $resp['res'] = $ventaDatos;
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }
}
