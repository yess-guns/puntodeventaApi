<?php

/**
 * 
 */


class Login extends Controlador
{

	public function __construct()
	{

		$this->modelUser = $this->modelos('modeloLogin');
		$this->login = $this->funcion('FLogin');
		//$this->session->delete();
		//$this->session->dump();


	}

	function checkemail($str)
	{
		return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}
	public function validated()
	{
		try{
			include  '../vendor/autoload.php';


			$response = [
				"tipo" => [
					"tipoID" => 0,
					"tipoNombre" => ''
				],
				"user" => [
					"userID" => 0,
					"userEmail" => ''
				],
				"token" => '',
				"actions" => [
					"comment" => 0
				]

			];


			/**
			 * IMPORTANT:
			 * You must specify supported algorithms for your application. See
			 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
			 * for a list of spec-compliant algorithms.
			 */

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$user = $_POST['email'];
				$pass = $_POST['password'];
				$ip = $_POST['ip'];
				$pais = $_POST['pais'];
				$region = $_POST['region'];
				$fecha = date('Y-m-d');
				$hora = date('h:i:s');
				if ($this->checkemail($user)) {
					if ($this->modelUser->validEmail($user)) {
						$userdb = $this->modelUser->validUser($user, $pass);
						if ($userdb) {
							$key = $this->login->genKey($userdb[0]['id_usuario']);
							$this->modelUser->initIngreso($userdb[0]['id_usuario'], $key, $ip, $pais, $region, $fecha, $hora);
							$response['tipo']['tipoID'] = $userdb[0]['id_permiso'];
							$response['tipo']['tipoNombre'] = $userdb[0]['nombrePermiso'];
							$response['user']['userID'] = $userdb[0]['id_usuario'];
							$response['user']['userEmail'] = $userdb[0]['email'];
							$response['token'] = $key;
						}
					}
				}
			}
			$jwt = \Firebase\JWT\JWT::encode($response, KEYJWT);
			//$decoded = \Firebase\JWT\JWT::decode($jwt, KEYJWT, array('HS256'));
			//echo json_encode($jwt);
			echo json_encode(['user' => $response, 'res' => 'OK']);
		}catch (Exception $e) {
		    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	}
	function index()
	{
		if ($this->session->get('intentos') >= 5) {
			$tiempo = (!empty($this->session->get('temp_blocked'))) ? $this->session->get('temp_blocked') - time() : 0;
			if (time() > $this->session->get('temp_blocked')) {
				$this->session->delete();
			} else {
				$data = [
					'tiempo' => $tiempo
				];
				$this->vista('login/blocked', $data);
			}
		} else {
			$data = [
				'url' => __CLASS__
			];
			$this->db = new Conexion();
			$this->vista('login/login', $data);
		}
	}
	function valida()
	{
		$user = $_POST['username'];
		$pass = $_POST['password'];
		if ($this->modelosUsers->validaUser($user)) {
			if ($this->modelosUsers->validaPass($pass)) {
				$Vuser = $this->modelosUsers->validaLogin($user, $pass);
				$this->session->set('usuario', $Vuser[0]['nombre']);
				$this->session->set('IdNombre', $Vuser[0]['id']);
				$this->session->set('permisos', $Vuser[0]['nombre_privilegio']);
				echo json_encode(1);
			} else {
				$this->trySession();
				echo json_encode(3);
			}
		} else {
			$this->trySession();
			echo json_encode(2);
		}
	}
	function trySession()
	{
		if ($this->session->validBy('intentos')) {
			$numSession = intval($this->session->get('intentos')) + 1;
			$this->session->deleteBy('intentos');
			$this->session->set('intentos', $numSession);
		} else {
			$this->session->set('intentos', 1);
		}
		//echo $numSession;
	}
	function validTrySession()
	{
		if ($this->session->get('intentos') > 5) {
			$this->session->set('temp_blocked', time() + 180);
			echo 1;
		} else {
			echo 2;
		}
	}
	function logOut()
	{
		$this->session->delete();
		$this->redirect('');
	}
}
