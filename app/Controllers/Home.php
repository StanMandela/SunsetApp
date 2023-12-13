<?php

namespace App\Controllers;

class Home extends BaseController
{
     /*Load model*/
     function __construct() {
   
        
     
        
    }
    function _load_view() {
     //   $this->data ['pending_activation'] = count($this->dawati_model->getPendingMentors());
    //    $this->data ['notification'] = $this->session->flashdata('notification');
        $this->load->view("template/temp");
    }  
    public function index()
    {
        //return view('products/products_index');
       return view('dashboard/products_dash');
      // return view('dash');
    }
    public function picPage(){
        return view('dashboard/upload_file');

    }
    public function uploadFile(){

            // Validation
            $input = $this->validate([
                 'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,jpg,jpeg,docx,pdf],'
            ]);
   
            if (!$input) { // Not valid
                 $data['validation'] = $this->validator; 
                 return view('dashboard/upload_file',$data); 
            }else{ // Valid
   
                 if($file = $this->request->getFile('file')) {
                       if ($file->isValid() && ! $file->hasMoved()) {
                            // Get file name and extension
                            $name = $file->getName();
                            $ext = $file->getClientExtension();
   
                            // Get random file name
                            $newName = $file->getRandomName(); 
   
                            // Store file in public/uploads/ folder
                            $file->move('../public/uploads/Receipts', $newName);
   
                            // File path to display preview
                            $filepath = base_url()."/uploads/Receipts".$newName;
                  
                            // Set Session
                            session()->setFlashdata('message', 'Uploaded Successfully!');
                            session()->setFlashdata('alert-class', 'alert-success');
                            session()->setFlashdata('filepath', $filepath);
                            //session()->setFlashdata('extension', $ext);
   
                       }else{
                            // Set Session
                            session()->setFlashdata('message', 'File not uploaded.');
                            session()->setFlashdata('alert-class', 'alert-danger');
                        
                       }
                 }
   
            }
     
            return redirect()->route('pic'); 
       
    }
    public function products()
    {
        return view('dashboard/products_dash');

    }
    public function sales()
    {
        return view('dashboard/sales_dash');

    }
    public function react()
    {
        return view('react');

    }
    public function itemTypes()
    {
        return view('dashboard/item_types');

    }
    public function productQuantities()
    {
        return view('dashboard/product_stock');

    }
    public function productPrices()
    {
        return view('dashboard/product_prices');

    }
}
    