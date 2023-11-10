<?php

namespace App\Lib;

use App\Lib\Response;
use App\Lib\ListaCodigoMensaje;

use PDO;
use PDOException;


abstract class Crud extends Connection{
    
	public $table;
    public $pdo;
	public $idTableName;
    public $response;


    public function __construct($table, $idTableName) {
        
		$this->table = $table;
		$this->idTableName = $idTableName;
        $this->pdo = parent::conexion();

        $this->response = new Response();

    }
	
	 public function getAll(){
        try
        {
            $stm = $this->pdo->prepare("SELECT * FROM $this->table");
            $stm->execute();
            
            $this->pdo = null;


            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            $this->response->setResponse(ListaCodigoMensaje::$ACCION_LEER_TODOS_REG, $e->getMessage(), ListaCodigoMensaje::$COD_ERROR);
			return $this->response;
        }
    }
	
	public function getById($id){
        try
        {
            $stm = $this->pdo->prepare("SELECT * FROM $this->table WHERE $this->idTableName = ?");
            $stm->execute(array($id));
            $this->pdo = null;

            return $stm->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            $this->response->setResponse(ListaCodigoMensaje::$ACCION_LEER_POR_ID, $e->getMessage(), ListaCodigoMensaje::$COD_ERROR);
			return $this->response;
        }
    }
	
	abstract function create();
    abstract function update();
	
	public function delete($id){
        try
        {
            $stm = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->idTableName = ?");
            $stm->execute(array($id));

            $this->pdo = null;

            $this->response->setResponse(ListaCodigoMensaje::$ACCION_ELIMINAR_REG, "Se ha eliminado correctamente el registro", ListaCodigoMensaje::$COD_ELIMINAR_REG );
            return $this->response;
        }
        catch (PDOException $e)
        {
            $this->response->setResponse(ListaCodigoMensaje::$ACCION_ELIMINAR_REG, $e->getMessage(), ListaCodigoMensaje::$COD_ERROR);
			return $this->response;
        }
    }

    public function deleteAllById($data){
        try
        {
		  			
		  foreach ($data as $id => $valor) {
			$this->pdo = parent::conexion();
			$this->delete($valor["id"]);
		  }
		 
            $this->response->setResponse(ListaCodigoMensaje::$ACCION_ELIMINAR_TODOS_REG, "Se ha eliminado correctamente los registros", ListaCodigoMensaje::$COD_ELIMINAR_TODOS_REG );
            return $this->response;
        }
        catch (PDOException $e)
        {
            $this->response->setResponse(ListaCodigoMensaje::$ACCION_ELIMINAR_TODOS_REG, $e->getMessage(), ListaCodigoMensaje::$COD_ERROR);
			return $this->response;
        }
    }
	
	    public function deleteAll(){
        try
        {
            $stm = $this->pdo->prepare("DELETE FROM $this->table");
            $stm->execute();

            $this->pdo = null;

            $this->response->setResponse(ListaCodigoMensaje::$ACCION_ELIMINAR_TODOS_REG, "Se ha eliminado correctamente el registro", ListaCodigoMensaje::$COD_ELIMINAR_TODOS_REG );
            return $this->response;
        }
        catch (PDOException $e)
        {
            $this->response->setResponse(ListaCodigoMensaje::$ACCION_ELIMINAR_TODOS_REG, $e->getMessage(), ListaCodigoMensaje::$COD_ERROR);
			return $this->response;
        }
    }
	
}

?>