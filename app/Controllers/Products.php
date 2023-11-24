<?php

namespace App\Controllers;
use App\Models\ProductsModel;
use App\Controllers\BaseController;

class Products extends BaseController
{
    protected $model;

    public function __construct()
    {
        // Load the model in the constructor
        $this->model = new ProductsModel();
    }

    public function index()
    {
        $this->model = new ProductsModel();
        $items=$this->model->findAll();
        return $this->response->setJSON($items);
    }
 
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function getProducts()
    {  
        $model = new ProductsModel();
        $products =$model->orderBy('created_at', 'asc')->findAll();

        return $this->response->setJSON($products);
    }
     /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        return view('projects/create');
    }
    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
         $model = new ProductsModel();
        
         // Get the last inserted item_id
         $lastItemId = $model->selectMax('product_id')->get()->getRow()->product_id;

         // Increment the item_id
         $newItemId = $lastItemId + 1 ?? 1 ;
         $timestamp = date('Y-m-d h:i:s');
        $data =[   
            'description'    => $this->request->getPost('description'),
            'product_name'    => $this->request->getPost('product_name'),
            'item_type'    => $this->request->getPost('item_type'),
            'product_id'    => $newItemId,  
            'created_at'    => $timestamp
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
    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new ProductsModel();
        $data =[   
            'description'    => $this->request->getPost('description'),
            'product_name'    => $this->request->getPost('product_name'),
        ];
 
        if ($model->where('id', $id)->set($data)->update() === false)
        {
            $message= $this->model->errors();
            $error= array(
                "status"=> 201,
                "message"=>$message
            );
            return $this->response->setJSON($error);
                }
 
         $data= array(
                    "status"=> 200,
                    "message"=>"Updated Successfully!"
                );
                return $this->response->setJSON($data); 
            
     }
     /**
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {   
        $model = new ProductsModel();
        $project = $model->find($id);
        if ($project === null){
            $message= $model->errors();
            $error= array(
                "status"=> 201,
                "message"=>$message
            );
            return $this->response->setJSON($error);
        }
        
        $data= array(
            "status"=> 200,
            "message"=>"Found Successfully!",
            "data"=>$project
        );
        return $this->response->setJSON($data); 
     
    }
     /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new ProductsModel();
        $status=$model->delete($id);
        if ($status === false)
        {
            //return redirect()->back()->withInput()->with('errors', $this->model->errors());
            $message= $this->model->errors();
            $error= array(
                "status"=> 201,
                "message"=>$message
            );
            return $this->response->setJSON($error);
        }
        $data= array(
            "status"=> 200,
            "message"=>"Deleted Successfully!"
        );
        return $this->response->setJSON($data);
    }
}
