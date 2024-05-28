<?php
require_once '../Database/Connection.php';
class Personas {
    public static function getAll() {
        $select = "SELECT * FROM personas";
        $db = new Connection();
        $results = $db->query($select);
        $datos = [];
        if($results->num_rows) {
            while($row = $results->fetch_assoc()) {
                $datos[] = [
                    'identificacion' => $row['identificacion'],
                    'nombre' => $row['nombre'],
                    'apellido' => $row['apellido'],
                    'tipo_identificacion' => $row['tipo_identificacion'],
                    'profesion' => $row['profesion']
                ];
            }
        }
        return $datos;
    }

    public static function getWhere($identificacion) {
        $db = new Connection();

        $where = "SELECT * FROM personas WHERE identificacion = '".$identificacion."'";

        $resultado = $db->query($where);
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                return [
                    'identificacion' => $row['identificacion'],
                    'nombre' => $row['nombre'],
                    'apellido' => $row['apellido'],
                    'tipo_identificacion' => $row['tipo_identificacion'],
                    'profesion' => $row['profesion']
                ];
            }
        }
        return $datos;
    }

    public static function insert($identificacion, $nombre, $apellido, $tipo_identificacion, $profesion) {
        $db = new Connection();
        $query = "INSERT INTO personas (identificacion, nombre, apellido, tipo_identificacion, profesion) VALUES('".$identificacion."', '".$nombre."', '".$apellido."', '".$tipo_identificacion."', '".$profesion."')";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function update($identificacion, $nombre, $apellido, $tipo_identificacion, $profesion) {
        $db = new Connection();
        $update = "UPDATE personas SET nombre = '".$nombre."', apellido ='".$apellido."', tipo_identificacion ='".$tipo_identificacion."', profesion ='".$profesion."' WHERE identificacion ='".$identificacion."'";

        $db->query($update);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function delete($id) {
        $db = new Connection();
        $query = "DELETE FROM personas WHERE identificacion='$id"."'";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

}
?>