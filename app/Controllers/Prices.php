<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PricesModel;
use App\Models\ProductsModel;

class Prices extends BaseController
{   
     protected $model;

    public function __construct()
    {
        // Load the model in the constructor
        $this->model = new PricesModel();
    }

    public function index()
    {
        $this->model = new PricesModel();
        $items=$this->model->findAll();
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
         $priceModel = new PricesModel();
         $productModel = new ProductsModel();

         // check if the price of the  product exists
            // Check if the product exists
        $existingProduct = $productModel->find($this->request->getPost('product_id'));
        if ($existingProduct) {
      
        $query = $priceModel->select('price')
                           ->where('product_id', $this->request->getPost('product_id'))
                           ->where('to_date', null)
                           ->get();

        if ($query->resultID->num_rows > 0) {
            $error= array(
                "status"=> 404,
                "message"=>"Product Price already exists. Try Updating"
            );
            return $this->response->setJSON($error);
        }
       
        // You can format the time if needed
        $timestamp = date('Y-m-d h:i:s');
        $data =[   
            'product_id'    => $this->request->getPost('product_id'),
            'price'    => $this->request->getPost('price'),
            'from_date'    => $timestamp,
            'updated_on'    => $timestamp            
        ];  
         
        if ($priceModel->insert($data) === false)
        {
            //return redirect()->back()->withInput()->with('errors', $this->model->errors());
            $message= $this->model->errors();
            $error= array(
                "status"=> 201,
                "message"=>$message
            );
            return $this->response->setJSON($error);
        }
 
        //return redirect()->back()->with('success', 'Saved Successfully!');
        $data= array(
            "status"=> 200,
            "message"=>"Saved Successfully!"
        );
        return $this->response->setJSON($data);

       }   else {
            // Product does not exist
           $error= array(
                "status"=> 201,
                "message"=>"The Product Doesnt Exist. Try adding it First."
            );
            return $this->response->setJSON($error);
        }
    }
    public function show($productId)
    {
        //var_dump($productId);
        $model = new PricesModel();

        // Build the query
        $query = $model->select('price')
                           ->where('product_id', $productId)
                           ->where('to_date', null)
                           ->get();

        // Check if there is a result
        if ($query->resultID->num_rows > 0) {
            $result = $query->getResult();
            $productPrice = $result[0]->price;
            $data= array(
                "status"=> 200,
                "product_id"=>$productId,
                "price"=>$productPrice
            );
            //return $this->response->setJSON($error);
            return $data;
        } else {
            $error= array(
                "status"=> 404,
                "prduct_id"=> "",
                "message"=>"No price found for the product."
            );
            return $error;
        }
    }
}
