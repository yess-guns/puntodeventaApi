<?php

class modeloInsumos
{

	private $db;

	public function __construct()
	{
		$db = new Conexion();
		$this->db = $db->conn();
	}
  //----Unidades
	public function getUnidades()
	{
		$data = $this->db->select("unidad", [
			"id_unidad",
			"nombreUnidad",
			"statusUnidad"
		]);
		return ($data) ? $data : [];
	}
  public function validUnidad($nombre)
  {
    $res = $this->db->has("unidad", [
    	"AND" => [
    		"nombreUnidad" => $nombre
    	]
    ]);
    return $res;
  }
  public function newUnidad($nombre)
  {
    $insert = $this->db->insert("unidad",
    [
      "nombreUnidad" => $nombre
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }
  public function editUnidad($idUnidad, $nombre)
  {
    $insert = $this->db->update("unidad",
      [
      "nombreUnidad" => $nombre
      ],
      [
        "id_unidad" => $idUnidad
      ]
    );

    return $insert->rowCount() === 1 ? true : false;

  }
  //----Medida
	public function getMedidas()
	{
		$data = $this->db->select("medida", [
			"id_medida",
			"nombreMedida",
			"statusMedida"
		]);
		return ($data) ? $data : [];
	}
  public function validMedida($nombre)
  {
    $res = $this->db->has("medida", [
    	"AND" => [
    		"nombreMedida" => $nombre
    	]
    ]);
    return $res;
  }
  public function newMedida($nombre)
  {
    $insert = $this->db->insert("medida",
    [
      "nombreMedida" => $nombre
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }
  public function editMedida($idMedida, $nombre)
  {
    $insert = $this->db->update("medida",
      [
      "nombreMedida" => $nombre
      ],
      [
        "id_medida" => $idMedida
      ]
    );
    return $insert->rowCount() === 1 ? true : false;
  }

  //----Categorias
	public function getCategorias()
	{
		$data = $this->db->select("categoriainsumo", [
			"id_categoriaIn",
			"nombreCategoriaIn",
			"statusCategoriaIn"
		]);
		return ($data) ? $data : [];
	}
  public function validCategoria($nombre)
  {
    $res = $this->db->has("categoriainsumo", [
    	"AND" => [
    		"nombreCategoriaIn" => $nombre
    	]
    ]);
    return $res;
  }
  public function newCategoria($nombre)
  {
    $insert = $this->db->insert("categoriainsumo",
    [
      "nombreCategoriaIn" => $nombre
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }
  public function editCategoria($idCategoria, $nombre)
  {
    $insert = $this->db->update("categoriainsumo",
      [
      "nombreCategoriaIn" => $nombre
      ],
      [
        "id_categoriaIn" => $idCategoria
      ]
    );

    return $insert->rowCount() === 1 ? true : false;
  }

  //----Insumos
	public function getInsumos()
	{
    $data = $this->db->select("insumo",
    [
      "[><]unidad" => ["id_unidad" => "id_unidad"],
      "[><]medida" => ["id_medida" => "id_medida"],
      "[><]categoriainsumo" => ["id_categoriaIn" => "id_categoriaIn"]
    ],
    [
			"insumo.id_insumo",
      "insumo.nombreInsumo",
      "unidad.id_unidad",
      "unidad.nombreUnidad",
      "medida.id_medida",
      "medida.nombreMedida",
      "categoriainsumo.id_categoriaIn",
      "categoriainsumo.nombreCategoriaIn",
      "insumo.catXmedida",
      "insumo.stockMinUnidad",
      "insumo.stockMinMedida",
      "insumo.stockInventario"
		]);
		return ($data) ? $data : [];
	}
  public function validInsumo($nombre)
  {
    $res = $this->db->has("insumo", [
    	"AND" => [
    		"nombreInsumo" => $nombre
    	]
    ]);
    return $res;
  }
  public function newInsumo($form)
  {
    $insert = $this->db->insert("insumo",
    [
      "id_unidad" => $form['unidad'],
      "id_categoriaIn" => $form['categoria'],
      "id_medida" => $form['medida'],
      "nombreInsumo" => $form['nombreI'],
      "catXmedida" => $form['cantidadM'],
      "stockMinUnidad" => $form['stockMinU'],
      "stockMinMedida" => $form['stockMinM'],
    ]);

    return $insert->rowCount() === 1 ? true : false;

  }
  public function editInsumo($idInsumo, $nombre)
  {
    $insert = $this->db->update("insumo",
      [
      "nombreInsumo" => $nombre
      ],
      [
        "id_insumo" => $idInsumo
      ]
    );

    return $insert->rowCount() === 1 ? true : false;

  }
}
