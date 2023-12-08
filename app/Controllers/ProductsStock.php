<?php

namespace App\Controllers;
use App\Models\ProductsModel;
use App\Models\ItemTypeModel;
use App\Models\ProductsStockModel;


use App\Controllers\BaseController;

class ProductsStock extends BaseController
{
    protected $model;
    public function __construct()
    {
        // Load the model in the constructor
        $this->model = new ProductsStockModel();
    }
    public function index()
    {
        $model = new ProductsStockModel();
        $query= $model->select('products_stock.*,products.product_name')
                            ->join('products','products_stock.product_id=products.product_id')
                            ->get();
                            $result = $query->getResult();
        return $this->response->setJSON($result);
    }
    public function create(){
        //enter the quantity and into the db 
        $model = new ProductsStockModel();
        
        // Get the last inserted item_id
       $productId= $this->request->getPost('product_id');
       // $lastItemId = $model->selectMax('product_id')->get()->getRow()->product_id;
        $query = $model->select('product_id')
            ->where('product_id', $productId)
             ->orderBy('id', 'DESC')  // Assuming 'id' is your primary key; adjust as needed
             ->limit(1)
             ->get();
         $lastItemId = $query->getRow();
            
        if($lastItemId===null){
            $timestamp = date('Y-m-d h:i:s')   ;
            // Retrieve JSON data using getJSON
                 
          $data = [   
              'product_id'    => $this->request->getPost('product_id'),
              'quantity'    => $this->request->getPost('quantity'),
              'latest_action'    => $this->request->getPost('action_type'),
              'updated_on'    => $timestamp
          ];
          if ($this->model->insert($data) === false)
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

        }
        $error= array(
            "code"=> 200,
            "status"=> false,
            "message"=>"Product Stock already exits. Try Add"
        );
        return $this->response->setJSON($error);
    }
    public function update($data){  
        $model = new ProductsStockModel();
        $timestamp = date('Y-m-d h:i:s')   ;

      
        if($data){
            
            $updateData = [   
                'quantity'    => $data['total_quantity'],
                'latest_action'    => $data['action_type'],
                'updated_on'    => $timestamp
            ];
          
     
            if ($model->where('product_id', $data['product_id'])->set($updateData)->update() === false)
            {
                $message= $this->model->errors();
                $error= array(
                    "status"=> 201,
                    "message"=>$message
                );
                return false;
                    }
     
                 $data= array(
                        "status"=> 200,
                        "message"=>"Updated Successfully!"
                    );
                    return true ; 
                
        }
        
        // get prduct id ,action(from sales or restock) and action type(restock/sale)
        // will get the current stock , and all or substract acc to the action
        //
    }
}
