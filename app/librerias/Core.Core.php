<?php
class Core
{
	protected $controlador = 'Login';
	protected $metodo = 'index';
	protected $parametros = [];

	public function __construct()
	{
		include 'class/Class.Header.php';
		$header = new Header();
		if ($header->getHeader()) {
			// controladores
			$url = $this->url();
			if (file_exists('../app/controladores/' . ucwords($url[0]) . '.php')) {
				$this->controlador = ucwords($url[0]);
				unset($url[0]);
			}
			require_once '../app/controladores/' . $this->controlador . '.php';
			$this->controlador = new $this->controlador;
			// metodos
			if (isset($url[1])) {
				if (method_exists($this->controlador, $url[1])) {
					$this->metodo = $url[1];
					unset($url[1]);
				}
			}
			//se eliminaron las posiciones 0 y 1 para dejar solo los parametros
			$this->parametros = $url ? array_values($url) : [];
			//retornar un array de parametros
			call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
		} else {
			$url = $this->url();
			if (ucwords($url[0]) == 'Login') {
				if (file_exists('../app/controladores/' . ucwords($url[0]) . '.php')) {
					$this->controlador = ucwords($url[0]);
					unset($url[0]);
				}
				require_once '../app/controladores/' . $this->controlador . '.php';
				$this->controlador = new $this->controlador;
				// metodos
				if (isset($url[1])) {
					if (method_exists($this->controlador, $url[1])) {
						$this->metodo = $url[1];
						unset($url[1]);
					}
				}
				//se eliminaron las posiciones 0 y 1 para dejar solo los parametros
				$this->parametros = $url ? array_values($url) : [];
				//retornar un array de parametros
				call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
			} else if (ucwords($url[0]) == 'PDF') {
				if (file_exists('../app/controladores/' . ucwords($url[0]) . '.php')) {
					$this->controlador = ucwords($url[0]);
					unset($url[0]);
				}
				require_once '../app/controladores/' . $this->controlador . '.php';
				$this->controlador = new $this->controlador;
				// metodos
				if (isset($url[1])) {
					if (method_exists($this->controlador, $url[1])) {
						$this->metodo = $url[1];
						unset($url[1]);
					}
				}
				//se eliminaron las posiciones 0 y 1 para dejar solo los parametros
				$this->parametros = $url ? array_values($url) : [];
				//retornar un array de parametros
				call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
			} else {
				echo json_encode('Token invalido');
			}
		}
	}
	public function url()
	{
		if (isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url;
		}
	}
	function getUrl()
	{
		$get_url = $_SERVER['REQUEST_URI'];
		$http_url = explode('/', $get_url);
		$array_rul = array(
			'controller' => (!empty($http_url[2])) ? $http_url[2] : null,
			'method' => (!empty($http_url[3])) ? $http_url[3] : null,
			'parametros' => (!empty($http_url[4])) ?  $http_url[4] : null,
		);
		return $array_rul;
	}
	function getUrlAll()
	{
		$get_url = $_SERVER['REQUEST_URI'];
		$http_url = explode('/', $get_url);
		for ($i = 0; $i < count($http_url); $i++) {
			$array_url[$i] = $http_url[$i];
		}
		return $array_url;
	}
	function getController()
	{
		$url = $this->getUrl();
		return $url['controller'];
	}
	function getMethod()
	{
		$url = $this->getUrl();
		return $url['method'];
	}
	function getParams()
	{
		$url = $this->getUrl();
		return $url['params'];
	}
}
