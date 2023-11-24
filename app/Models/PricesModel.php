<?php

namespace App\Models;

use CodeIgniter\Model;

class PricesModel extends Model
{
    protected $table            = 'prices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id','price','from_date','to_date','updated_on'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'product_id' => [
            'label' => 'Product Id',
            'rules' => 'required|greater_than_equal_to[0]'
        ],
        'price' => [
            'label' => 'Price',
            'rules' => 'required|greater_than_equal_to[0]'
        ],
        'from_date' => [
            'label' => 'From Date',
            'rules' => 'required'
        ],
        'updated_on' => [
            'label' => 'Updated on ',
            'rules' => 'required'
        ],
      
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
