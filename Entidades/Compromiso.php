<?php
require_once '../Database/Connection.php';
class Compromiso {
    public static function getAll() {
        $select = "SELECT * FROM compromisos";
        $db = new Connection();
        $results = $db->query($select);
        $datos = [];
        if($results->num_rows) {
            while($row = $results->fetch_assoc()) {
                $datos[] = [
                    'idcompromiso' => $row['idcompromiso'],
                    'organizador' => $row['organizador'],
                    'fecha_inicio' => $row['fecha_inicio'],
                    'fecha_fin' => $row['fecha_fin'],
                    'hora_inicio' => $row['hora_inicio'],
                    'hora_fin' => $row['hora_fin'],
                    'titulo' => $row['titulo'],
                    'descripcion' => $row['descripcion'],
                    'lugar' => $row['lugar'],
                    'modalidad' => $row['modalidad'],
                    'capacidad' => $row['capacidad']
                    
                ];
            }
        }
        return $datos;
    }

    public static function getWhere($organizador) {
        $db = new Connection();

        $where = "SELECT * FROM compromisos WHERE organizador = ".$organizador." AND fecha_fin > CURDATE() ORDER BY fecha_inicio";

        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idcompromiso' => $row['idcompromiso'],
                    'organizador' => $row['organizador'],
                    'fecha_inicio' => $row['fecha_inicio'],
                    'fecha_fin' => $row['fecha_fin'],
                    'hora_inicio' => $row['hora_inicio'],
                    'hora_fin' => $row['hora_fin'],
                    'titulo' => $row['titulo'],
                    'descripcion' => $row['descripcion'],
                    'lugar' => $row['lugar'],
                    'modalidad' => $row['modalidad'],
                    'capacidad' => $row['capacidad']
                ];
            }
        }
        return $datos;
    }

    public static function getOtherOnes($organizador) {
        $db = new Connection();

        $where = "
        SELECT compromisos.*, CONCAT(personas.nombre, ' ', personas.apellido) AS nombre_organizador FROM compromisos 
        JOIN personas ON personas.identificacion = compromisos.organizador
        WHERE 
                organizador != '".$organizador."' 
            AND 
                fecha_fin > CURDATE() 
            AND
                idcompromiso NOT IN (SELECT compromiso FROM participantes WHERE participante = '".$organizador."')
            ORDER BY fecha_inicio ASC;";

        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idcompromiso' => $row['idcompromiso'],
                    'organizador' => $row['organizador'],
                    'fecha_inicio' => $row['fecha_inicio'],
                    'fecha_fin' => $row['fecha_fin'],
                    'hora_inicio' => $row['hora_inicio'],
                    'hora_fin' => $row['hora_fin'],
                    'titulo' => $row['titulo'],
                    'descripcion' => $row['descripcion'],
                    'lugar' => $row['lugar'],
                    'modalidad' => $row['modalidad'],
                    'capacidad' => $row['capacidad'],
                    'nombre_organizador' => $row['nombre_organizador']
                ];
            }
        }
        return $datos;
    }

    public static function insert($organizador, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin, $titulo, $descripcion, $lugar, $modalidad, $capacidad) {
        $db = new Connection();
        $query = "INSERT INTO compromisos (organizador, fecha_inicio, fecha_fin, hora_inicio, hora_fin, titulo, descripcion, lugar, modalidad, capacidad) VALUES
        ('".$organizador."', '".$fecha_inicio."', '".$fecha_fin."', '".$hora_inicio."','".$hora_fin."','".$titulo."','".$descripcion."','".$lugar."','".$modalidad."',".$capacidad.")";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function update($idcompromiso, $organizador, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin, $titulo, $descripcion, $lugar, $modalidad, $capcidad) {
        $db = new Connection();
        $update = "UPDATE compromiso 
        SET organizador = '".$organizador."', fecha_inicio ='".$fecha_inicio."', fecha_fin ='".$fecha_fin."', hora_inicio ='".$hora_inicio."', hora_fin='".$hora_fin."', titulo='".$titulo."', descripcion='".$descripcion."', lugar='".$lugar."', modalidad='".$modalidad."', capacidad='".$capacidad."' WHERE idcompromiso=.$idcompromiso.";

        $db->query($update);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function delete($id) {
        $db = new Connection();
        $query = "DELETE FROM compromisos WHERE idcompromiso='$id"."'";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

}
?>