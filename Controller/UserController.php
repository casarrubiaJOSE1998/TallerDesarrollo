<?php
    require_once '../Entidades/User.php';
    // Set CORS headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    $datos = json_decode(file_get_contents('php://input'));
 
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            $findUser = isset($_GET['findUser'])? $_GET['findUser']: null;
            if ($findUser != NULL) {
                echo json_encode(User::findUser($findUser));
                break;
            }
            $user = isset($_GET['user'])? $_GET['user']: NULL;
            $pass = isset($_GET['password'])? $_GET['password']: NULL;
            if ($user != NULL && $pass != NULL) {
                $jwtToken = User::getWhere($user, $pass);
                if ($jwtToken == null) {
                    http_response_code(401);
                    exit();
                }
                /* echo json_encode(['token' => 'Bearer '.$jwtToken]); */
                echo json_encode($jwtToken);
                http_response_code(200);
            }
            else {
                http_response_code(400);
            }
            break;
        case 'POST':
            if(User::insert($datos->identificacion, $datos->user, $datos->password)) {
                http_response_code(200);
            } else { http_response_code(400); }
            break;

        case 'PUT':
                if(User::update($datos->identificacion, $datos->nombre, $datos->apellido, $datos->tipo_identificacion, $datos->profesion)) {
                    http_response_code(200);
                } else { http_response_code(400); }
            break;
        default:
            http_response_code(500);
            break;
    }

?>