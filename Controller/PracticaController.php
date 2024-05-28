<?php
    require_once('..\Database\Encryptation.php');
    $data = json_decode(file_get_contents('php://input'), true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $data['username'];
        $password = $data['password'];

        // Aquí debería ir la lógica para validar el usuario (consulta a base de datos, etc.)
        if ($username === 'admin' && $password === 'password') {
            $token = JWTdata::generateJWT('1'); // Supongamos que el userId es 1
            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $userData = JWTdata::validateJWT($token);
            if ($userData) {
                echo json_encode(['message' => 'Access granted', 'user' => $userData]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid token']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'No token provided']);
        }
    }
?>