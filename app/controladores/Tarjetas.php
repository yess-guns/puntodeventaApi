<?php
class Tarjetas extends Controlador
{

	public function __construct()
	{
    $this->modelo = $this->modelos('modeloTarjetas');
    $this->resp = [
      'status' => 'err',
      'res' => 'Metodo invalido'
    ];
	}
	public function getTiposTarjeta(){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $tipos = $this->modelo->getTipos();
      $acepta = $this->modelo->getAceptacion();

      $resp['status'] = 'OK';
      $resp['res']['tiposT'] = $tipos;
      $resp['res']['tiposA'] = $acepta;
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }
}
