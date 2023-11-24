<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemTypeModel extends Model
{
    protected $table            = 'item_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type_id','type_name','description'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'type_name' => [
            'label' => 'Type Name',
            'rules' => 'required|max_length[250]'
        ],
        'type_id' => [
            'label' => 'Item Id',
            'rules' => 'required|greater_than_equal_to[0]'
        ],
        'description' => [
            'label' => 'Item Name',
            'rules' => 'required|max_length[250]|alpha_space'
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
