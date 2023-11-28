<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SalesModel;
use App\Models\PricesModel;
use App\Controllers\Prices;
use App\Services\Services;
use App\Models\ProductsModel;


class Sales extends BaseController
{
    protected $model;

    public function __construct()
    {
        // Load the model in the constructor
        $this->model = new SalesModel();
        $this->priceController = new Prices();
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
         $salesModel = new SalesModel();
         $services = new Services();
         $productModel= new ProductsModel();

          // Load the validation library
    $validation = \Config\Services::validation();

    // Define the rules for validation
    $rules = [
        'product_id' => 'required',
        'quantity' => 'required|numeric', // Change 'numeric' to the appropriate validation rule for quantity
    ];

    // Set the rules in the validation library
    $validation->setRules($rules);
     // Perform the validation
    if ($validation->run($this->request->getPost())) {
        // Validation passed, proceed with your logic
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        // Your logic here...
       
    }else{
        // Validation failed, handle the errors
        $errors = $validation->getErrors();
          $errorMessage= $this->extractFirstKey($errors)  ;
        // Output or handle the errors as needed
        $data= array(
            "status"=> FALSE,
            "code"=>200,
            "message"=>$errorMessage
        );
        return $this->response->setJSON($data);
    }
        // Get the name of the product getProductType
        $product = $productModel->getProductDetails($this->request->getPost('product_id')) ?? null;
        if($product ===null){

            $data= array(
                "status"=> FALSE,
                "code"=>200,
                "message"=>"Can't make a sale of a non existent product "
            );
            return $this->response->setJSON($data);
        }
        // Check if a sale already exists for the given product and date
        $saleDate = date('Y-m-d'); // You may need to adjust the date format
        $status1 =$salesModel->saleExists($this->request->getPost('product_id'),$saleDate);
        if ($salesModel->saleExists($this->request->getPost('product_id'), $saleDate)) {
            // A sale already exists for the same product and date
            $data= array(
                "status"=> FALSE,
                "code"=>200,
                "message"=>"Sale  for ".$product['product_name']." already Exists!. Try Editing"
            );
            return $this->response->setJSON($data);
        } else {
                // Create a new sale record
              
                // Call the method from the service
                $price = $services->showPrice("1"); 
                if($price['status'] === 404){
                    $error= array(
                        "status"=> $price['status'],
                        "message"=>$price['message']
                    );
                    return $this->response->setJSON($error);
                }
               
                // You can format the time if needed
                $timestamp = date('Y-m-d h:i:s');
               $amount= $this->request->getPost('quantity')* $price['price'];
             
                $data =[   
                    'product_id'    => $this->request->getPost('product_id'),
                    'quantity'    => $this->request->getPost('quantity'),
                    'price'    => $price['price'],
                    'item_type'    =>$product['item_type'] , 
                    'created_at'=> $timestamp,
                    'amount'=> $amount
                
                    ];

                   
            
            if ($this->model->insert($data) === false)
            {
                return redirect()->back()->withInput()->with('errors', $this->model->errors());
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
                "message"=>"Sale saved Successfully!"
            );
            return $this->response->setJSON($data);
        }
    }
 // Function to extract the value of the first key
function extractFirstKey($response) {
    $firstKey = reset($response);
    return is_string($firstKey) ? $firstKey : '';
}

}
