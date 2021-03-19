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

	public function getProductos($idCategoria){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $Productos = $this->modelo->getProductos($idCategoria);
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
        if($form['tipo'] == 2){
          $addProd = $this->modelo->newProductoReceta($form);
        }else{
          $addProd = $this->modelo->newProductoUnidad($form);
        }
        
        if($addProd === true){
          $resp['status'] = 'OK';//Todo bien
        }elseif($addProd === 0) {
          $resp['status'] = 0;//soló se guardo el producto pero no sus insumos
        }else{
          $resp['status'] = 'error';// error total
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
      $form = json_decode($_POST['form'], true);
      $valid = $this->modelo->validProductoEdit($form['id'],$form['nombreP']);
      if($valid){
        $resp['status'] = 'existing';
      }else{
        $addI = $this->modelo->editProducto($form);
        if($addI === true){
          $resp['status'] = 'OK';//Todo bien
        }else{
          $resp['status'] = 'error';// error total
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
  public function editProducto2(){//Eliminar
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

  public function addInsumosProducto(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $idProducto = json_decode($_POST['id_producto'], true);
      $insumos = json_decode($_POST['insumos'], true);
      $addI = $this->modelo->addInsumosProducto($idProducto, $insumos);
        if($addI === true){
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
  //Venta
  public function getCateProductos(){
		$resp = [
      'status' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $categorias = $this->modelo->getCategoriasProd();
      foreach($categorias as $key => $cate){
        $productos = $this->modelo->getProductosByCate($cate['id_categoriaPro']);
        $categorias[$key]['productos'] = $productos;
      }
      $resp['status'] = 'OK';
      $resp['cateProd'] = $categorias;
      echo json_encode($resp);
    }else{
      echo json_encode($this->resp);
    }
  }

}
