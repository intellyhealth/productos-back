<?php

use App\Model\Producto;

$app->group('/api/', function () {
    
    $this->get('productos/test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('Hello Servicio de Productos');
    });
    
    //Obtener todos los registros
    $this->get('productos', function ($req, $res, $args) {
        
        $um = new Producto(null);
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });


    //Obtener registro por id
    $this->get('productos/{id}', function ($req, $res, $args) {
        
		$um = new Producto(null);
        $um->producto_id =  $args['id'];
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->getById($um->producto_id)
            )
        );
    });
	

    //Insertar registro
    $this->post('productos', function ($req, $res) {
         
		 $um = new Producto($req->getParsedBody());
                
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->create()
            )
        );
    });

    //Actualizar registro
    $this->put('productos', function ($req, $res) {
        
		$um = new Producto($req->getParsedBody());
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->update()
            )
        );
    });
    
    //Eliminar registro por id
    //
    $this->delete('productos/{id}', function ($req, $res, $args) {
        
		$um = new Producto(null);
        $um->producto_id = $args["id"]; 

        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->delete($um->producto_id)
            )
        );
    });

    $this->delete('productos', function ($req, $res) {
        
		$um = new Producto(null);
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->deleteAll()
            )
        );
    });
	
	$this->post('productos/all', function ($req, $res) {
         
		 
		 $um = new Producto(null);
                
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->deleteAllById($req->getParsedBody())
            )
        );
    });
    
});