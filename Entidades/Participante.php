<?php
require_once '../Database/Connection.php';
class Participante {
    public static function getAll() {
        $select = "SELECT * FROM participantes";
        $db = new Connection();
        $results = $db->query($select);
        $datos = [];
        if($results->num_rows) {
            while($row = $results->fetch_assoc()) {
                $datos[] = [
                    'idparticipante' => $row['idparticipante'],
                    'compromiso' => $row['compromiso'],
                    'participante' => $row['participante']
                ];
            }
        }
        return $datos;
    }

    public static function getWhere($idparticipante) {
        $db = new Connection();

        $where = "SELECT * FROM participantes WHERE idparticipante = ".$idparticipante."";

        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idparticipante' => $row['idparticipante'],
                    'compromiso' => $row['compromiso'],
                    'participante' => $row['participante']
                ];
            }
        }
        return $datos;
    }

    public static function insert($compromiso, $participante) {
        $db = new Connection();
        $query = "INSERT INTO participantes (compromiso, participante) VALUES (".$compromiso.", ".$participante.")";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function delete($id) {
        $db = new Connection();
        $query = "DELETE FROM participantes WHERE idparticipante=".$id;
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

}
?>