<?php
require_once '../Database/Connection.php';
class Acta {
    public static function getAll() {
        $select = "SELECT * FROM acta";
        $db = new Connection();
        $results = $db->query($select);
        $datos = [];
        if($results->num_rows) {
            while($row = $results->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion']
                ];
            }
        }
        return $datos;
    }

    public static function getWhere($idacta) {
        $db = new Connection();

        $where = "SELECT * FROM acta WHERE idacta = ".$idacta."";

        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion']
                ];
            }
        }
        return $datos;
    }

    public static function insert($pertenece, $fecha, $hora, $lugar_emision, $descripcion) {
        $db = new Connection();
        $query = "INSERT INTO acta (pertenece, fecha, hora, lugar_emision, descripcion) VALUES
        (".$pertenece.", '".$fecha."', '".$hora."', '".$lugar_emision."','".$descripcion."')";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function update($idacta, $pertenece, $fecha, $hora, $lugar_emision, $descripcion) {
        $db = new Connection();
        $update = "UPDATE acta 
        SET pertenece = ".$pertenece.", fecha ='".$fecha."', hora ='".$hora."', lugar_emision ='".$lugar_emision."', descripcion='".$descripcion."' WHERE idacta=".$idacta;

        $db->query($update);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function delete($id) {
        $db = new Connection();
        $query = "DELETE FROM acta WHERE idacta=".$id;
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

}
?>