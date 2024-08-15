<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'description', 'price', 'stock'];
    protected $validationRules = [
        'name'        => 'required|min_length[3]|max_length[255]',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer',
    ];
}
