<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Products extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';
    private $secretKey = 'tu_clave_secreta_jwt';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $products = $this->model->findAll();
        return $this->respond($products);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $product = $this->model->find($id);
        if ($product) {
            return $this->respond($product);
        }
        return $this->failNotFound('Producto no encontrado');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true);

        if ($this->model->insert($data)) {
            return $this->respondCreated($data, 'Producto creado exitosamente');
        }

        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        // Verificar si el producto existe
        $product = $this->model->find($id);

        if (!$product) {
            return $this->failNotFound('Producto no encontrado');
        }

        $data = $this->request->getJSON(true);

        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data, 'Producto actualizado exitosamente');
        }
        
        return $this->fail('No se pudo actualizar el producto');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        // Verificar si el producto existe
        $product = $this->model->find($id);

        if ($product) {
            $this->model->delete($id);
            return $this->respondDeleted($product, 'Producto eliminado');
        }
        return $this->failNotFound('Producto no encontrado');
    }

    // Proteger las rutas con JWT
    private function validateToken()
    {
        $authHeader = $this->request->getHeader("Authorization");

        if (!$authHeader) {
            return $this->failUnauthorized('Token no proporcionado');
        }

        $token = explode(' ', $authHeader->getValue())[1]; // Obtener el token de 'Bearer <token>'

        try {
            $decoded = JWT ::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token inválido o expirado');
        }
    }
}
