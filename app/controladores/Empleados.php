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

}
