<?php
class Usuarios extends Controlador
{

	public function __construct()
	{
		$this->modelo = $this->modelos('modeloUsuarios');
    $this->resp = [
      'status' => 'err',
      'res' => 'Metodo invalido'
    ];
  }

  public function getPermisos(){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      
      $permisos = $this->modelo->getPermisos();
      if(count($permisos) > 0){
        $resp['status'] = 'OK';
        $resp['res'] = $permisos;
      }else{
        $resp['status'] = 'err';
      }
      echo json_encode($resp);
      
    }else{
      echo json_encode($this->resp);
    }
  }
  
	public function getUsuarios(){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $usuarios = $this->modelo->getUsuarios();
      $this->resp['status'] = 'OK';
      $this->resp['res'] = $usuarios;
      echo json_encode($this->resp);
      
    }else{
      echo json_encode($this->resp);
    }
  }

  public function newUser(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $form = json_decode($_POST['form'], true);
      $valid = $this->modelo->validUser($form['email']);
      if($valid){
        $this->resp['status'] = 'existing';
      }else{
        $addU = $this->modelo->newUser($form);
        if($addU){
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

  public function editUser(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_usuario = $_POST['id_usuario'];
      $data = $_POST['data'];
      $tipo = $_POST['tipo'];
      if($tipo == 1){
        $valid = $this->modelo->validUser($data);
        if($valid){
          $this->resp['status'] = 'existing';
        }else{
          $editEmail = $this->modelo->editEmail($data, $id_usuario);
          if($editEmail){
            $this->resp['status'] = 'OK';
          }else{
            $this->resp['status'] = 'error';
            $this->resp['res'] = 'Error de sintaxis';
          }  
        }
            
      }else{
        $editPermiso = $this->modelo->editPermiso($data, $id_usuario);
        if($editPermiso){
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

  public function changePass(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_usuario = $_POST['id_usuario'];
      $pass = $_POST['pass'];
      $change = $this->modelo->changePass($id_usuario,$pass);
      $this->resp['res'] = $change;
      echo json_encode($this->resp);
      
    }else{
      echo json_encode($this->resp);
    }
  }
  public function changeStatus(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_usuario = $_POST['id_usuario'];
      $estatus = $_POST['estatus'];
      $change = $this->modelo->changeStatus($id_usuario,$estatus);
      $this->resp['res'] = $change;
      echo json_encode($this->resp);
      
    }else{
      echo json_encode($this->resp);
    }
  }

}
