<?php
class Ventas extends Controlador
{

	public function __construct()
	{
    $this->modelo = $this->modelos('modeloVentas');
    $this->modeloMesas = $this->modelos('modeloMesas');
    $this->resp = [
      'status' => 'err',
      'res' => 'Metodo invalido'
    ];
	}
  
	public function newVenta(){
		$resp = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idEmpleado = $_POST['id_empleado'];
      $mesas = json_decode($_POST['mesaSelect'], true);
      $comensales = $_POST['comensales'];
      $venta = $this->modelo->newVenta($idEmpleado, $mesas, $comensales);
      if($venta){
        $resp = 'OK';
      }elseif($venta === 0){
        $resp = 'exception';
      }else{
        $resp = 'fatalError';
      }
      echo json_encode(['resp' => $resp, 'idVenta' => $venta]);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function getMesasDisp(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $mesas = $this->modelo->getMesasDisp();
      $resp['status'] = 'OK';
      $resp['res'] = $mesas;
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function ventaById($idVenta){
		$resp = [
      'status' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $mesas = $this->modeloMesas->mesasVenta($idVenta);
      $resp['status'] = 'OK';
      $resp['mesas'] = $mesas;
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function savePedido(){
		$resp = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idVenta = $_POST['idVenta'];
      $idEmpleado = $_POST['idEmpleado'];
      $pedido = json_decode($_POST['pedido'], true);
      $save = $this->modelo->savePedido($idVenta, $pedido, $idEmpleado);
      if($save === true){
        $resp = 'OK';
      }else{
        $resp = 'fatalError';
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
