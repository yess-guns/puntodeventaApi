<?php
class Productos extends Controlador
{

	public function __construct()
	{
		$this->modelo = $this->modelos('modeloProductos');
	}
  //----------------------Admin-------------------
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
      $idCategoria = $_POST['id_categoriaPro'];
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

  //Productos

	public function getProductos(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $Productos = $this->modelo->getProductos();
      $resp['status'] = 'OK';
      $resp['res'] = $Productos;
      echo json_encode($resp);
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }
  public function newProducto(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $form = json_decode($_POST['form'], true);
      $valid = $this->modelo->validProducto($form['nombreP']);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $addI = $this->modelo->newProducto($form);
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
  public function editProducto(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idProducto = $_POST['id_producto'];
      $nombre = $_POST['nombrePEdit'];
      $valid = $this->modelo->validProducto($nombre);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $update = $this->modelo->editProducto($idProducto, $nombre);
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
}
