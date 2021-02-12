<?php
require '../vendor/autoload.php';

use Medoo\Medoo;

class Conexion
{

	public function __construct()
	{
		/*try {
			$this->dbh = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
		} catch (mysqli_sql_exception $e) {
			$this->error = $e->getMessage();
		}*/
		/*parent::__construct($this->host,$this->user,$this->pass,$this->dbname);
	    $this->connect_errno ? die('Error en la conexión a la base de datos') : null;
	    $this->set_charset("utf8");*/
	}
	public function conn()
	{
		return new Medoo([
			'database_type' => 'mysql',
			'database_name' => DB_NAME,
			'server' => 'localhost',
			'username' => DB_USER,
			'password' => DB_PASS,
			'charset' => 'utf8',
			'collation' => 'utf8_general_ci'
		]);
	}
	/*public function query($query){
		$result = $this->dbh->query($query);
		return $result;
	}

	public function resultquery($query){
		$result = $this->dbh->query($query);
		$num = $result->num_rows;
		while ($row = $result->fetch_object()) {
			$rows[] = $row;
		}
		if ($num == 0) {
			$rows = array();
		}
		return $rows;
	}*/
}
