<?php  

/**
* 
*/
class Session {
	
	function __construct() {
		if (isset($_SESSION)) {
			
		}else{
			session_start();
		}
		
	}
	public function set($nombre, $valor) {
		$_SESSION[$nombre] = $valor;
	}
	public function get($nombre) {
		if (isset($_SESSION[$nombre])) {
			return $_SESSION[$nombre];
		} else {
			return false;
		}
	}
	public function validBy($nombre) {
		if (isset($_SESSION[$nombre])) {
			return true;
		} else {
			return false;
		}
	}
	public function deleteBy($nombre) {
		if (isset($_SESSION[$nombre])) {
			unset($_SESSION[$nombre]);
		}
	}
	public function delete() {
		if (isset($_SESSION)) {
			session_destroy ();
		}
	}
	public function dump()
	{
		echo "<pre>";
		var_dump($_SESSION);
		echo "</pre>";
	}
}

?>