<?php

namespace App\Models;

use CodeIgniter\Model;

class StockValueModel extends Model
{
    protected $table            = 'stock_value';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mpesa_balance','stock_value','purchases','date','lodging','updated_on'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'stock_value' => [
            'label' => 'Stock Value',
            'rules' => 'required|greater_than_equal_to[0]'
        ],
        'updated_on' => [
            'label' => 'Updated On',
            'rules' => 'required'
        ],
        'date' => [
            'label' => 'Date ',
            'rules' => 'required'
        ]
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
