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
        $items = $this->model
            ->select('prices.*, products.product_name')
            ->join('products', 'products.product_id = prices.product_id', 'left')
            ->where('to_date', null)->findAll();
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
        $existingProduct = $productModel->getProductDetails($this->request->getPost('product_id')) ?? null;

        if ($existingProduct) {

            $query = $priceModel->select('current_price')
                ->where('product_id', $this->request->getPost('product_id'))
                ->where('to_date', null)
                ->get();

            if ($query->resultID->num_rows > 0) {
                $error = array(
                    "status" => 404,
                    "message" => "Product Price already exists. Try Updating"
                );
                return $this->response->setJSON($error);
            }

            // You can format the time if needed
            $timestamp = date('Y-m-d h:i:s');
            $data = [
                'product_id'    => $this->request->getPost('product_id'),
                'current_price'    => $this->request->getPost('price'),
                'from_date'    => $timestamp,
                'updated_on'    => $timestamp
            ];

            if ($priceModel->insert($data) === false) {
                //return redirect()->back()->withInput()->with('errors', $this->model->errors());
                $message = $this->model->errors();
                $error = array(
                    "status" => 201,
                    "message" => $message
                );
                return $this->response->setJSON($error);
            }

            //return redirect()->back()->with('success', 'Saved Successfully!');
            $data = array(
                "status" => 200,
                "message" => "Saved Successfully!"
            );
            return $this->response->setJSON($data);
        } else {
            // Product does not exist
            $error = array(
                "status" => 201,
                "message" => "The Product Doesnt Exist. Try adding it First."
            );
            return $this->response->setJSON($error);
        }
    }
    public function show($id) //dont edit this function its being 
    {
        //var_dump($productId);
        $model = new PricesModel();

        //get the id param from request
       // $id = $this->request->getGet('id')?? null;

        // Build the query
        $query = $model->query("SELECT current_price FROM prices WHERE product_id = ?", $id);

        if ($query->resultID->num_rows > 0) {
            $result = $query->getResult();
            $currentPrice = $result[0]->current_price;
            $data = array(
                "status" => 200,
                "product_id" => $id,
                "price" => $currentPrice    
            );
            return  $data;
        }else {
            $error = array(
                "status" => 404,
                "product_id" => $id,
                "message" => "No price found for the product."
            );
            return  $error;
        }
    }
    public function update()
    {
        $model = new PricesModel();
        $productId= $this->request->getPost('product_id');
        $newPrice= $this->request->getPost('new_price');
        $timestamp = date('Y-m-d h:i:s');

        $lastRecord = $model->where('product_id', $productId)
                      ->orderBy('id', 'desc') // Adjust the ordering criteria
                      ->limit(1)
                      ->get()
                      ->getRow();

        if($lastRecord){

        }else{
            $error = array(
                "status" => 404,
                "product_id" => $productId,
                "message" => "No price found for the product."
            );
            return  $this->response->setJSON($error);
        }

        // set a new value for the current row 
        $updateData=[
            'to_date'  => $timestamp

        ];
        if ($model->where('product_id', $productId)->set($updateData)->update())
        {

            
        $data =[   
            'product_id'=>  $productId,
            'current_price'    => $newPrice,
            'previous_price'    => $lastRecord->current_price,
            'from_date'  => $timestamp,
            'updated_on'=>$timestamp

        ];

        if( $this->model->insert($data)=== false){
            $message= $this->model->errors();
            $error= array(
                "status"=> 201,
                "message"=>$message
            );
            return $this->response->setJSON($error);
        }
        $data= array(
            "status"=> 200,
            "message"=>"Price Updated  Successfully!"
        );
        return $this->response->setJSON($data);
        }
        
        
        // Retrieve the last record for the specified product ID
     
    

       

        return false; // Handle the case where no previous record is found
    }
}
