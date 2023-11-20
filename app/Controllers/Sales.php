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
    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
         $model = new SalesModel();

        $data =[   
            'product_id'    => $this->request->getPost('product_id'),
            'quantity'    => $this->request->getPost('quantity'),
            'price'    => $this->request->getPost('price'),
            'item_type'    => $this->request->getPost('item_type'), 
            'created_at'=> 'CURRENT_TIMESTAMP'
        ];
         
        if ($this->model->insert($data) === false)
        {
            //return redirect()->back()->withInput()->with('errors', $this->model->errors());
            // $message= $this->model->errors();
            // $error= array(
            //     "status"=> 201,
            //     "message"=>$message
            // );
            // return $this->response->setJSON($error);
        }
 
        //return redirect()->back()->with('success', 'Saved Successfully!');
        $data= array(
            "status"=> 200,
            "message"=>"Sale saved Successfully!"
        );
        return $this->response->setJSON($data);
    }

}
