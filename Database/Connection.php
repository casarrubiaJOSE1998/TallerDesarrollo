<?php
class Connection extends Mysqli {

    function __construct() {
        parent::__construct('localhost', 'root', 'toor', 'actividad_php');
        $this->set_charset('utf8');
        $this->connect_error == NULL ? 'Conexión generada' : die('Error.');
    }

}
?>
