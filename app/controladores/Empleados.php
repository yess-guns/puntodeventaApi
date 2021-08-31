<?php
class Empleados extends Controlador
{

	public function __construct()
	{
		$this->modelo = $this->modelos('modeloEmpleados');
  }
  
	public function validEmpleado(){
		$resp = [
      'status' => '',
      'res' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $clave = $_POST['clave'];
      $tipoEmpleado = $_POST['tipoEmpleado'];
      $valid = $this->modelo->validEmpleado($clave, $tipoEmpleado);
      if($valid === false){
        $resp['status'] = 'invalid';
        echo json_encode($resp);
      }else{
      $resp['status'] = 'OK';
      $resp['res'] = $valid;
      echo json_encode($resp);
      }
      
    }else{
      $resp['status'] = 'err';
      $resp['res'] = 'Metodo invalido';
      echo json_encode($resp);
    }
  }

  public function getTipoEmpleado(){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      
      $tipoEmp = $this->modelo->getTipoEmpleado();
      $resp['status'] = 'OK';
      $resp['res'] = $tipoEmp;
      echo json_encode($resp);
      
    }else{
      echo json_encode($this->resp);
    }
  }

  public function getEmpleados(){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $empleados = $this->modelo->getEmpleados();
      $this->resp['status'] = 'OK';
      $this->resp['res'] = $empleados;
      echo json_encode($this->resp);
      
    }else{
      echo json_encode($this->resp);
    }
  }

  public function nuevoEmpleado(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $form = json_decode($_POST['form'], true);
      $valid = $this->modelo->validClave($form['clave']);
      if($valid){
        $this->resp['status'] = 'existing';
      }else{
        $addE = $this->modelo->nuevoEmpleado($form);
        if($addE){
          $this->resp['status'] = 'OK';
        }else{
          $this->resp['status'] = 'error';
          $this->resp['res'] = 'Error de sintaxis';
        }
      }
      echo json_encode($this->resp);
    }else{
      echo json_encode($this->resp);
    }
  }

  public function editEmpleado(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $form = json_decode($_POST['form'], true);
      $valid = $this->modelo->validClave2($form['id_empleado'],$form['clave']); 
      if($valid){
        $this->resp['status'] = 'existing';
      }else{
        $addE = $this->modelo->editEmpleado($form);
        if($addE){
          $this->resp['status'] = 'OK';
        }else{
          $this->resp['status'] = 'error';
          $this->resp['res'] = 'Error de sintaxis';
        }
      }
      echo json_encode($this->resp);
    }else{
      echo json_encode($this->resp);
    }
  }

}
