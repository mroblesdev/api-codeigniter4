<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends ResourceController
{
    private $secretKey = 'tu_clave_secreta_jwt'; // Clave secreta para firmar los tokens

    // Registro de usuario
    public function register()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $userModel->save($data);

        return $this->respondCreated(['message' => 'Usuario registrado con éxito']);
    }

    // Login y generación de token JWT
    public function login()
    {
        $userModel = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Credenciales inválidas');
        }

        // Generar el token JWT
        $payload = [
            'iat' => time(), // Tiempo de emisión
            'exp' => time() + 3600, // Expira en una hora
            'uid' => $user['id'],
            'username' => $user['username'],
        ];

        $token = JWT::encode($payload, $this->secretKey, 'HS256');

        return $this->respond(['token' => $token], 200);
    }

    // Método para validar el token
    private function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
