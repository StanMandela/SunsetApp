<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyQuantiesModel extends Model
{
    protected $table            = 'daily_quantities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id','old_quantity','quantity','total_quantity','action_type','updated_at'];

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
            'rules' => 'required|max_length[250]'
        ],
        'old_quantity' => [
            'label' => 'Old Quantity',
            'rules' => 'required|greater_than_equal_to[0]'
        ],
        'quantity' => [
            'label' => 'Quantity',
            'rules' => 'required|greater_than_equal_to[0]'
        ],
        'action_type' => [
            'label' => 'Item Type',
            'rules' => 'required|max_length[250]'    
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
