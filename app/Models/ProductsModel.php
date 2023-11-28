<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id','description','product_name','item_type','created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'description' => [
            'label' => 'Descriptions',
            'rules' => 'required|max_length[250]'
        ],
        'product_id' => [
            'label' => 'Item Id',
            'rules' => 'required|greater_than_equal_to[0]'
        ],
        'product_name' => [
            'label' => 'Product Name',
            'rules' => 'required|max_length[250]'
        ],
        'item_type' => [
            'label' => 'Item Type',
            'rules' => 'required|greater_than_equal_to[0]'
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

    // functions
    public function getProductDetails($productId)
    {
        $product = $this->find($productId);

        return $product 
        ? ['item_type' => $product['item_type'], 'product_name' => $product['product_name']] 
        : null;
    }
    public function getProductName()
    {
        // Assuming 'product_type' is the foreign key in ProductsModel and 'item_id' is the primary key in ItemTypeModel
        $this->select('products.*, item_types.type_name AS product_type_name')
             ->join('item_types', 'item_types.type_id = products.item_type', 'left');
        return $this->orderBy('created_at', 'asc')->findAll();
    }
 
}
