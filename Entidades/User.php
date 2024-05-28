<?php
require_once '../Database/Connection.php';
require_once '../Database/Encryptation.php';
class User {

    public static function findUser($user) {
        $db = new Connection();
        $where = "SELECT user_name FROM usuarios WHERE user_name = '".$user."'";
        $resultado = $db->query($where);
        return ($resultado->num_rows > 0);
    }

    public static function getWhere($user, $password) {
        $db = new Connection();
        $where = "SELECT * FROM usuarios WHERE user_name = '".$user."' AND user_password = SHA('".$password."')";
        
        $resultado = $db->query($where);
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                // Generación de la JWT
                $data = JWTdata::generateJWT($row['id']);
                return $data;
            }
        }
        return null;
    }

    public static function insert($identificacion, $usuario, $contra) {
        $db = new Connection();
        $query = "INSERT INTO usuarios (id, user_name, user_password) VALUES('".$identificacion."', '".$usuario."', SHA('".$contra."'))";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function update($identificacion, $usuario, $contra) {
        $db = new Connection();
        $update = "UPDATE usuarios SET user_password = '".$user_password."' WHERE identificacion ='".$identificacion."' AND user_name='".$usuario."'";

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