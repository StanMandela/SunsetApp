<?php

namespace App\Controllers;
use App\Models\ProductsModel;
use App\Controllers\BaseController;

class Products extends BaseController
{
    public function index()
    {
        $model = new ProductsModel();
        $items=$model->findAll();
        return $this->response->setJSON($items);
    }
    protected $modelName = 'App\Models\ProductsModel';
 
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function getProducts()
    {  
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
 
         // Get the last inserted item_id
         $lastItemId = $model->selectMax('item_id')->get()->getRow()->item_id;

         // Increment the item_id
         $newItemId = $lastItemId + 1;

        $data = [
            'name' => $this->request->getPost('name'),
            'description'    => $this->request->getPost('description'),
            'item_name'    => $this->request->getPost('item_name'),
            'item_type'    => $this->request->getPost('item_type'),
            'item_id'    => $lastItemId,            

        ];
         
        if ($this->model->insert($data) === false)
        {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
 
        return redirect()->back()->with('success', 'Saved Successfully!');
    }
    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        return view('projects/edit', ['project' => $this->model->find($id)]);
    }
}
