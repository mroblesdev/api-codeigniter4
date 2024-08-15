<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Products extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

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
}
