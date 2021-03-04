<?php

class modeloProductos
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}
  //----Categorias
	public function getCategorias()
	{
		$data = $this->db->select("categoriaproducto", [
			"id_categoriaPro",
			"nombrecategoriaPro",
			"statusCategoriaPro"
		]);
		return ($data) ? $data : [];
	}
  public function validCategoria($nombre)
  {
    $res = $this->db->has("categoriaproducto", [
    	"AND" => [
    		"nombrecategoriaPro" => $nombre
    	]
    ]);
    return $res;
  }
  public function newCategoria($nombre)
  {
    $insert = $this->db->insert("categoriaproducto",
    [
      "nombrecategoriaPro" => $nombre
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }
  public function editCategoria($idCategoria, $nombre)
  {
    $insert = $this->db->update("categoriaproducto",
      [
      "nombrecategoriaPro" => $nombre
      ],
      [
        "id_categoriaPro" => $idCategoria
      ]
    );

    return $insert->rowCount() === 1 ? true : false;
  }

  //----Insumos
	public function getProductos()
	{
    $data = $this->db->select("producto",
    [
      "[><]categoriaproducto" => ["id_categoriaPro" => "id_categoriaPro"],
      "[><]tipoproducto" => ["id_tipoPoducto" => "id_tipoPoducto"],
      "[><]destino" => ["id_destino" => "id_destino"]
    ],
    [
			"producto.id_producto",
      "producto.nombreProducto",
      "producto.precio",
      "producto.stock",
      "categoriaproducto.id_categoriaPro",
      "categoriaproducto.nombrecategoriaPro",
      "tipoproducto.id_tipoPoducto",
      "tipoproducto.nombreTipoProducto",
      "destino.id_destino",
      "destino.nombreDestino"
		]);
		return ($data) ? $data : [];
	}
  public function validProducto($nombre)
  {
    $res = $this->db->has("producto", [
    	"AND" => [
    		"nombreProducto" => $nombre
    	]
    ]);
    return $res;
  }
  public function newProducto($form)
  {
    $insert = $this->db->insert("producto",
    [
      "id_categoriaPro" => $form['categoria'],
      "id_tipoPoducto" => $form['tipo'],
      "id_destino" => $form['destino'],
      "nombreProducto" => $form['nombreP'],
      "precio" => $form['precio']
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }
  public function editProducto($idProducto, $nombre)
  {
    $insert = $this->db->update("producto",
      [
      "nombreProducto" => $nombre
      ],
      [
        "id_producto" => $idProducto
      ]
    );

    return $insert->rowCount() === 1 ? true : false;

  }
}
