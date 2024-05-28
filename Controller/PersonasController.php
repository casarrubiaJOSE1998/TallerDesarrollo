<?php
    require_once '../Entidades/Personas.php';
    require_once '../Database/Encryptation.php';
    // Set CORS headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    $datos = json_decode(file_get_contents('php://input'));

    
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    // DESENCRIPTACIÓN DE LOS DATOS.
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $userData = JWTdata::validateJWT($token);
            if ($userData) {
                $id = $userData['sub'];
            } else {
                http_response_code(401);
                exit();
            }
        }
        else {
            http_response_code(401);
            exit();
        }
    }

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            echo json_encode(Personas::getWhere($id)); 
            break;

        case 'POST':
            if(Personas::insert($datos->identificacion, $datos->nombre, $datos->apellido, $datos->tipo_identificacion, $datos->profesion)) {
                http_response_code(200);
            }
            else {
                http_response_code(400);
            }
            break;

        case 'PUT':
                if(Personas::update($datos->identificacion, $datos->nombre, $datos->apellido, $datos->tipo_identificacion, $datos->profesion)) {
                    http_response_code(200);
                } else { http_response_code(400); }
            break;

        case 'DELETE':
            if(Personas::delete($datos->identificacion)) { http_response_code(200); }
            else { http_response_code(400); }
            break;
        
        default:
            http_response_code(405);
            break;
    }
?>