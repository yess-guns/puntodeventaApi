<?php
class Insumos extends Controlador
{

	public function __construct()
	{
		$this->modelo = $this->modelos('modeloInsumos');
	}
  //----------------------Admin-------------------
  //Unidades
	public function getUnidades(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $unidades = $this->modelo->getUnidades();
      $resp['status'] = 'OK';
      $resp['res'] = $unidades;
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function newUnidad(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nombre = $_POST['nombreU'];
      $valid = $this->modelo->validUnidad($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $addU = $this->modelo->newUnidad($nombre);
        if($addU){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function editUnidad(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idUnidad = $_POST['id_unidad'];
      $nombre = $_POST['nombreUEdit'];
      $valid = $this->modelo->validUnidad($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $update = $this->modelo->editUnidad($idUnidad, $nombre);
        if($update){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  //Medidas
  public function getMedidas(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $medidas = $this->modelo->getMedidas();
      $resp['status'] = 'OK';
      $resp['res'] = $medidas;
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function newMedida(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nombre = $_POST['nombreM'];
      $valid = $this->modelo->validMedida($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $addM = $this->modelo->newMedida($nombre);
        if($addM){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function editMedida(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idMedida = $_POST['id_medida'];
      $nombre = $_POST['nombreMEdit'];
      $valid = $this->modelo->validMedida($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $update = $this->modelo->editMedida($idMedida, $nombre);
        if($update){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  //Categorias
	public function getCategorias(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $categorias = $this->modelo->getCategorias();
      $resp['status'] = 'OK';
      $resp['res'] = $categorias;
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function newCategoria(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nombre = $_POST['nombreC'];
      $valid = $this->modelo->validCategoria($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $addU = $this->modelo->newCategoria($nombre);
        if($addU){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function editCategoria(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idCategoria = $_POST['id_categoriaIn'];
      $nombre = $_POST['nombreCEdit'];
      $valid = $this->modelo->validCategoria($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $update = $this->modelo->editCategoria($idCategoria, $nombre);
        if($update){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }

  //Insumos
  public function getDataFormInsumo()
  {
    $resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $unidades = $this->modelo->getUnidades();
      $medidas = $this->modelo->getMedidas();
      $categorias = $this->modelo->getCategorias();
      $dataForm = [
        'unidades' => $unidades,
        'medidas' => $medidas,
        'categorias' => $categorias
      ];
      $resp['status'] = 'OK';
      $resp['res'] = $dataForm;
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
	public function getInsumos(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $insumos = $this->modelo->getInsumos();
      $resp['status'] = 'OK';
      $resp['res'] = $insumos;
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function newInsumo(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $form = json_decode($_POST['form'], true);
      $valid = $this->modelo->validInsumo($form['nombreI']);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $addI = $this->modelo->newInsumo($form);
        if($addI){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function editInsumo(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idInsumo = $_POST['id_insumo'];
      $nombre = $_POST['nombreIEdit'];
      $valid = $this->modelo->validInsumo($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $update = $this->modelo->editInsumo($idInsumo, $nombre);
        if($update){
          $resp['status'] = 'OK';
        }else{
          $resp['status'] = 'error';
          $resp['res'] = 'Error de sintaxis';
        }        
      } 
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function getInsumosProduc($idProducto){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $insumos = $this->modelo->getInsumosProducto($idProducto);
      $resp['status'] = 'OK';
      $resp['res'] = $insumos;
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function updateStatusInP(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idProIn = $_POST['id_productoIn'];
      $status = $_POST['status'];
      
      $update = $this->modelo->updateStatusInP($idProIn, $status);
      if($update){
        $resp['status'] = 'OK';
      }else{
        $resp['status'] = 'error';
        $resp['res'] = 'Error de sintaxis';
      }
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function updateCantidadInP(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idProIn = $_POST['id_productoIn'];
      $cantidad = $_POST['cantidad'];
      
      $update = $this->modelo->updateCantidadInP($idProIn, $cantidad);
      if($update){
        $resp['status'] = 'OK';
      }else{
        $resp['status'] = 'error';
        $resp['res'] = 'Error de sintaxis';
      }
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
}
