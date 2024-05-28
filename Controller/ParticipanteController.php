<?php
    require_once '../Entidades/Participante.php';
    require_once '../Database/Encryptation.php';
    $datos = json_decode(file_get_contents('php://input'));
    // Set CORS headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    $datos = json_decode(file_get_contents('php://input'));
 
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }

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
    }
    else {
        http_response_code(401);
        exit();
    }
    
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            if($datos != NULL) { 
                echo json_encode(Participante::getWhere($datos->idparticipante)); 
            }
            else { 
                echo json_encode(Participante::getAll()); 
            }
            break;

        case 'POST':
            if(Participante::insert(
            $datos->compromiso,
            $id)) {
                http_response_code(200);
            }
            else {
                http_response_code(400);
            }
            break;

        case 'PUT':
                http_response_code(404);
            break;

        case 'DELETE':
            if(Participante::delete($datos->idparticipante)) { http_response_code(200); }
            else { http_response_code(400); }
            break;
        
        default:
            http_response_code(405);
            break;
    }
?>