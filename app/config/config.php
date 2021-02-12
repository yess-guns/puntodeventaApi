<?php
$url = "http://" . $_SERVER['HTTP_HOST'];

// base de datos
$config = [
  'host' => 'localhost',
  'user' => 'root',
  'pass' => '',
  'dbname' => 'puntodeventa'
];

// DB Params 
define("DB_HOST", $config['host']);
define("DB_USER", $config['user']);
//define("DB_USER", "garenco_resta");
define("DB_PASS", $config['pass']);
//define("DB_PASS", "14122019");
define("DB_NAME", $config['dbname']);
//define("DB_NAME", "restaurant");


//url para entrar a la carpeta app
define("RUTAAPP", dirname(dirname(__FILE__)));
//url para acceder a la carpeta public
define("RUTAPUBLIC", $url . "/puntodeventa");

define('KEYJWT', 'sdljkfg34hvjfgasfjlhhsdvfwejbkhgwrjhvf');
