<?php

header('Content-Type: application/json; charset=utf-8');

switch($_SERVER['REQUEST_METHOD']){
    case 'PUT':       
        $postBody = file_get_contents("php://input");
        $data = json_decode($postBody,true);
        _put($data);
        break;
    case 'DELETE':
        $postBody = file_get_contents("php://input");
        $data = json_decode($postBody,true);
        _delete($data);
        break;
    case 'GET':
        _get();
        break;
    case 'POST':
        $postBody = file_get_contents("php://input");
        $data = json_decode($postBody,true);
        _post($data);
        break;
    default:
        header('HTTP/1.1 405 Method not allowed');
        header('Allow: GET, PUT, DELETE');
        break;
}


function _get()
{
    include("conexion.php");
    $stmt = null;
    $respuesta = array();
    try
    {
        if(isset($_GET['tela']))
        {
            if($stmt =  $mysqli->prepare("SELECT id, nombre, pais FROM telas WHERE id = ?;"))
            {
                $stmt->bind_param("i",$_GET['tela']);
                $stmt->execute();
            }

        }
        else
        {
            if($stmt =  $mysqli->prepare( "SELECT id, nombre, pais FROM telas"))
            {
                $stmt->execute();
            }
        }


        if(isset($stmt))
        {
            
            $stmt->bind_result($id,$nombre,$pais);
            while ($stmt->fetch()) {
                
                $tela = (object) array(
                    'id' =>$id,
                    'nombre' => utf8_encode($nombre),
                    'pais' => $pais
                );
                array_push($respuesta, $tela);   
            }

            $stmt->free_result();
            $stmt->close();
        }


    }
    catch (Exception $e) {
        echo "Exception ::";
        echo $e->getMessage();

    }
    finally {
        try {
            $mysqli->close();
            
        } catch (Exception $e) {
            echo '0';
        }
    }
    
    echo json_encode($respuesta);
}

function _post($datos)
{
    $respuesta=1;
    if( isset($datos['nombre'])  && isset($datos['pais'])){
        include("conexion.php");

        try{
            if($stmt = $mysqli->prepare("INSERT INTO telas (nombre, pais) VALUES(?,?);"))
            {
                $stmt->bind_param("ss",$datos['nombre'],$datos['pais']);
                $stmt->execute();

            }
            else
            {
                echo "No disponible ::";
            }
        }catch (Exception $e) {
            //echo "Exception ::";
            //echo $e->getMessage();
            
        }
        finally {
            try {
                $mysqli->close();    
            } catch (Exception $e) {
                echo '0';
            }
        }
    }
    else
    {
        //echo "Sin datos";
         die("Error: Sin datos.");
    }
    echo json_encode($respuesta);
}


function _delete($datos){
    $respuesta=1;
    if( isset($datos['tela']) ){
        include("conexion.php");

        try{
            if($stmt = $mysqli->prepare("DELETE FROM telas WHERE id=?;"))
            {
                $stmt->bind_param("i",$datos['tela']);
                $stmt->execute();
            }
            else
            {
                echo "No disponible ::";
            }
        }catch (Exception $e) {
            //echo "Exception ::";
            //echo $e->getMessage();
            
        }
        finally {
            try {
                $mysqli->close();    
            } catch (Exception $e) {
                echo '0';
            }
        }
    }
    else
    {
        //echo "Sin datos";
         die("Error: Sin datos.");
    }
    echo json_encode($respuesta);
}


function _put($datos){
    $respuesta=1;
    if( isset($datos['tela']) && isset($datos['nombre']) && isset($datos['pais']) ){
        include("conexion.php");

        try{
            if($stmt = $mysqli->prepare("UPDATE telas SET nombre=?, pais=? WHERE id=?;"))
            {
                $stmt->bind_param("ssi",$datos['nombre'],$datos['pais'],$datos['tela']);
                $stmt->execute();

            }
            else
            {
                echo "No disponible ::";
            }
        }catch (Exception $e) {
            //echo "Exception ::";
            //echo $e->getMessage();
            
        }
        finally {
            try {
                $mysqli->close();    
            } catch (Exception $e) {
                echo '0';
            }
        }
    }
    else
    {
        //echo "Sin datos";
         die("Error: Sin datos.");
    }
    echo json_encode($respuesta);
}