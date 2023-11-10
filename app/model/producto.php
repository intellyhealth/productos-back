<?php
namespace App\Model;

use App\Lib\ListaCodigoMensaje;
use PDO;
use PDOException;

use App\Lib\Crud;

class Producto extends Crud
{

  /* campos de la tabla */
  public  $producto_id;
  private $titulo; // relación tabla producto
  private $img;
  private $precio;
 
  const TABLE 		= 'producto'; 	  // Nombre de la tabla fisica
  const IDNAMETABLE = 'producto_id';  // nombre del id de la tabla fisica
  
   
	public function __construct($data)
	{
		parent::__construct(self::TABLE, self::IDNAMETABLE);

		$this->producto_id	= $data["producto_id"];
		$this->titulo		= $data["titulo"];
		$this->img			= $data["img"];
		$this->precio		= $data["precio"];
	}
	
 
	public function create(){
		try{
			$sql = "INSERT INTO $this->table (titulo, img, precio) VALUES (?, ?, ?)";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($this->titulo, $this->img, $this->precio));
			$this->pdo = null;

	     	$this->response->setResponse(ListaCodigoMensaje::$ACCION_AGREGAR_REG, "Se ha creado correctamente el registro", ListaCodigoMensaje::$COD_AGREGAR_REG );
         	return $this->response;
		 
	   }catch(PDOException $e){
		
			$this->response->setResponse(ListaCodigoMensaje::$ACCION_AGREGAR_REG, $e->getMessage(), ListaCodigoMensaje::$COD_ERROR );
			return $this->response;
	   }
	}

	public function update(){
		try{
		 
		 $sql = "UPDATE $this->table SET titulo = ?, img = ?, precio=? WHERE $this->idTableName = ?";
		 $stm = $this->pdo->prepare($sql);
		 $stm->execute(array($this->titulo, $this->img, $this->precio, $this->producto_id));
		 
		 $this->pdo = null;

		 $this->response->setResponse(ListaCodigoMensaje::$ACCION_MODIFICAR_REG, "Se ha modificado correctamente el registro", ListaCodigoMensaje::$COD_MODIFICAR_REG );
		 return $this->response;
		 
	   }catch(PDOException $e){
			$this->response->setResponse(ListaCodigoMensaje::$ACCION_MODIFICAR_REG, $e->getMessage(), ListaCodigoMensaje::$COD_ERROR);
			return $this->response;
	   }
	}

	
}