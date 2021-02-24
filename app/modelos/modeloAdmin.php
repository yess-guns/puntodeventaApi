<?php

class modeloAdmin
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
		$data = $this->db->select("insumo", [
			"id_insumo",
			"nombreInsumo",
			"statusInsumo"
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
  public function newInsumo($nombre)
  {
    $insert = $this->db->insert("insumo",
    [
      "nombreInsumo" => $nombre
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
