<?php
// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Manejo de solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../Entidades/Compromiso.php';
require_once '../Database/Encryptation.php';

$datos = json_decode(file_get_contents('php://input'));

$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $userData = JWTdata::validateJWT($token);
    if ($userData) {
        $id = $userData['sub'];
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit();
    }
} else {
    http_response_code(401);
    exit();
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['others'])) {
            echo json_encode(Compromiso::getOtherOnes($id));
            http_response_code(200);
            exit();
        }

        echo json_encode(Compromiso::getWhere($id)); 
        http_response_code(200);
        exit();
        break;

    case 'POST':
        if (Compromiso::insert(
            $id,
            $datos->fecha_inicio, 
            $datos->fecha_fin, 
            $datos->hora_inicio, 
            $datos->hora_fin, 
            $datos->titulo, 
            $datos->descripcion, 
            $datos->lugar, 
            $datos->modalidad, 
            $datos->capacidad)) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        break;

    case 'PUT':
        if (Compromiso::update(
            $datos->idcompromiso, 
            $id,
            $datos->fecha_inicio, 
            $datos->fecha_fin, 
            $datos->hora_inicio, 
            $datos->hora_fin, 
            $datos->titulo, 
            $datos->descripcion, 
            $datos->lugar, 
            $datos->modalidad, 
            $datos->capacidad)) {
            http_response_code(200);
        } else { 
            http_response_code(400); 
        }
        break;

    case 'DELETE':
        if (Compromiso::delete($datos->idcompromiso)) { 
            http_response_code(200); 
        } else { 
            http_response_code(400); 
        }
        break;

    default:
        http_response_code(405);
        break;
}
?>