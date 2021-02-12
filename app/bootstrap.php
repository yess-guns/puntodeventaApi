<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization,X-API-KEY, Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST");
date_default_timezone_set('America/Mexico_City');
//session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'config/config.php';
require_once 'librerias/redireccionamiento.php';

//autoload
spl_autoload_register(function ($clase) {
	require_once 'librerias/Core.' . $clase . '.php';
});
