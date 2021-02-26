<?php

/**
 * 
 */
class modeloLogin
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}

	public function validEmail($email)
	{
		$datas = $this->db->select("usuarios", [
			"email"
		], [
			"email" => $email
		]);
		return ($datas) ? true : false;
	}
	public function validUser($email, $pass)
	{
		$password = md5($pass);
		$datas = $this->db->select(
			"usuarios",
			[
				"[><]permisos" => ["id_permiso" => "id_permiso"]
			],
			[
				"usuarios.id_usuario",
				"usuarios.email",
				"usuarios.id_permiso",
				"permisos.nombrePermiso",
				"permisos.clave"
			],
			[
				"usuarios.email" => $email,
				"usuarios.contrasella" => $password,
				"usuarios.estatus" => 1
			]
		);
		return ($datas) ? $datas : false;
	}
	public function getComent($id)
	{
		$datas = $this->db->select(
			"comentarios",
			"*",
			[
				"id_usuario" => $id
			]
		);
		return ($datas) ? 1 : 0;
	}
	public function initIngreso($idUSer, $key, $ip, $pais, $region, $fecha, $hora)
	{
		$datas = $this->db->insert(
			"ingreso",
			[
				"id_usuario" => $idUSer,
				"key" => $key,
				"ip" => $ip,
				"pais" => $pais,
				"region" => $region,
				"fecha" => $fecha,
				"hora" => $hora,
				"estatus" => 1
			]
		);
		return ($datas) ? true : false;
	}
}
