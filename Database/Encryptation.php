<?php

    require '../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    class JWTdata {
        private static $secretKey = 'Le7uAWhSe7Cu75tGR6h3Fg==';

        public static function generateJWT($userId) {
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600; // Token válido por 1 hora
            $payload = [
                'iat' => $issuedAt,
                'exp' => $expirationTime,
                'sub' => $userId,
            ];

            return JWT::encode($payload, self::$secretKey, 'HS256');
        }

        public static function validateJWT($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key(self::$secretKey, 'HS256'));
                return (array) $decoded;
            } catch (Exception $e) {
                return false;
            }
        }

        public static function removeElementFromJWT($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key(self::$secretKey, 'HS256'));
                $payload = (array) $decoded;
                foreach($payload as $data) {
                    echo $data;
                }
                unset($payload[$element]);
    
                return JWT::encode($payload, self::$secretKey, 'HS256');
            } catch (Exception $e) {
                return false;
            }
        }

    }
?>