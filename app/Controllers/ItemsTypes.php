<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ItemTypeModel;

class ItemsTypes extends BaseController
{
    protected $model;

    public function __construct()
    {
        // Load the model in the constructor
        $model = new ItemTypeModel();
    }
    public function index()
    {
        $this->model = new ItemTypeModel();
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
        $model = new ItemTypeModel();

         // Get the last inserted item_id
         $lastItemId = $model->selectMax('type_id')->get()->getRow()->type_id;
         //var_dump($lastItemId);

         // Increment the item_id
         $newItemId = $lastItemId + 1 ?? 1 ;
         $timestamp = date('Y-m-d h:i:s');
        $data =[   
            'description'    => $this->request->getPost('description'),
            'type_name'    => $this->request->getPost('type_name'),
            'type_id'    => $newItemId, 
            'created_at' => $timestamp
        ];
         
        if ($model->insert($data) === false)
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
            "status"=> true,
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
        $model = new ItemTypeModel();
        $data =[   
            'description'    => $this->request->getPost('description'),
            'type_name'    => $this->request->getPost('type_name'),
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
        $model = new ItemTypeModel();
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
        $model = new ItemTypeModel();
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
