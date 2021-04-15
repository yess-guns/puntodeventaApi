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
      $comensales = $this->modelo->comensalesVenta($idVenta);
      $statusPago = $this->modelo->validPagoV($idVenta);
      $resp['status'] = 'OK';
      $resp['mesas'] = $mesas;
      $resp['comensales'] = $comensales['comensales'];
      $resp['statusPago'] = $statusPago;
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

  public function getDatosVentaCajero($idVenta){
		$resp = [
      'status' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $productosVenta = [];
      $productosDistinct = $this->modelo->getProductosDistinct($idVenta);

      foreach($productosDistinct as $producto){
        $productoV = $this->modelo->getPlatilloVenta($idVenta, $producto['id_producto']);
        $cantidad = count($productoV);
        //var_dump($productoV);
        $precioUni = floatval($productoV[0]['precio']);
        array_push($productosVenta,[
          'nombreProducto' => $productoV[0]['nombreProducto'],
          'cantidad' => $cantidad,
          'precioUni' => $precioUni,
          'importe' => $cantidad * $precioUni
        ]);
      }
      //validar si ya tiene pago
      $pago = $this->modelo->getPagoVentaC($idVenta);
      $pagoV = $pago == false ? null : $this->getTiposPagoVenta($pago);
      $mesero = $this->modelo->getMeseroVenta($idVenta);
      $resp['status'] = 'OK';
      $resp['res'] = [
        "venta" => $productosVenta,
        "pago" => $pagoV,
        "mesero" => $mesero
      ];
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function getTiposPagoVenta($dataPago){
    $pEfectivo = $this->modelo->getDataPagoEfectivo($dataPago['id_pago']);
    $pTarjeta = $this->modelo->getDataPagoTarjeta($dataPago['id_pago']);
    $dataPago['pagoEf'] = $pEfectivo;
    $dataPago['pagoTj'] = $pTarjeta;
    return $dataPago;
  }

  public function pay(){
		$resp = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idVenta = $_POST['idVenta'];
      $idEmpleado = $_POST['id_empleado'];
      $precioTotal = $_POST['precioTotal'];
      $dataPago = json_decode($_POST['pago'], true);
      $pay = $this->modelo->pay($idVenta, $idEmpleado, $precioTotal, $dataPago);
      if($pay != false){
        $this->resp['status'] = 'OK';
        $this->resp['res'] = $this->getPago($pay);
      }else{
        $this->resp['status'] = 'error';
      }
      echo json_encode($this->resp);
    }else{
      echo json_encode($this->resp);
    }
  }
  public function getPago($idPago){
    $dataPago = $this->modelo->getdataPago($idPago);
    $pEfectivo = $this->modelo->getDataPagoEfectivo($idPago);
    $pTarjeta = $this->modelo->getDataPagoTarjeta($idPago);
    $dataPago['pagoEf'] = $pEfectivo;
    $dataPago['pagoTj'] = $pTarjeta;
    //echo json_encode($dataPago);
    return $dataPago;
  }

  public function finVenta(){
		$resp = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idVenta = $_POST['idVenta'];
      $finish = $this->modelo->finVenta($idVenta);
      if($finish == true){
        $resp = 'OK';
      }else{
        $resp = 'error';
      }
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function cancelarVenta(){
		$resp = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idVenta = $_POST['idVenta'];
      $idEmpleado = $_POST['idEmpleado'];
      $cancel = $this->modelo->cancelarVenta($idVenta, $idEmpleado);
      if($cancel == true){
        $resp = 'OK';
      }else{
        $resp = 'error';
      }
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function cancelarProducto(){
		$resp = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_ventaDatos = $_POST['id_ventaDatos'];
      $cancel = $this->modelo->cancelarProducto($id_ventaDatos);
      if($cancel == true){
        $resp = 'OK';
      }else{
        $resp = 'error';
      }
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

}
