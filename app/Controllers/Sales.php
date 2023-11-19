<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SalesModel;

class Sales extends BaseController
{
    protected $model;

    public function __construct()
    {
        // Load the model in the constructor
        $this->model = new SalesModel();
    }
    public function index()
    {
        $this->model = new SalesModel();
        $items=$this->model->orderBy('created_at', 'asc')->findAll();
        return $this->response->setJSON($items);
    }
    
}
