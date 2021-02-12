<?php 
	class Controlador extends Core{
		public function modelos($modelo){
			require_once '../app/modelos/'.$modelo.'.php';
			return new $modelo();
		}
		public function funcion($funcion){
			require_once '../app/librerias/class/Class.'.$funcion.'.php';
			return new $funcion();
		}
		public function funcionFPDF(){
			require_once '../app/librerias/class/Class.PDF_Code128.php';
			//return new PDF_Code128();
			return new PDF_Code128($orientation='L',$unit='mm', array(50,76));
		}
		public function funcionFPDFH(){
			require_once '../app/librerias/class/Class.PDF_Code128.php';
			//return new PDF_Code128();
			return new PDF_Code128();
		}
		public function funcionFPDFP(){
			require_once '../app/librerias/class/Class.PDF_Code128.php';
			//return new PDF_Code128();
			return new PDF_Code128($orientation='L',$unit='mm', array(125,102));
		}
		public function funcionTCPDF($funcion){
			require_once '../app/librerias/class/Class.'.$funcion.'.php';
			return new $funcion('P', 'mm', array(200, 600), true, 'UTF-8', false);
		}
		public function vista($url, $data = []){
			if (file_exists('../app/vistas/'.$url.'.php')) {
				extract($data,EXTR_PREFIX_SAME, "wddx");
				include '../app/vistas/'.$url.'.php';
			}else{
				die('Esta vista no existe');
			}
		}
		function redirect($pagina){
			header("location:".RUTAPUBLIC."/".$pagina);
		}
	}
