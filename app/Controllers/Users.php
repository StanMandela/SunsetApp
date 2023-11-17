<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Controllers\BaseController;

class Users extends BaseController
{
    protected $helpers = ['html', 'form'];
    public function index()
    {
        $model = new UsersModel();
        $items = $model->findAll();
        /// return $this->response->setJSON($items);
       return view ('index',["items"=>$items]);
    }
    public function insertData()

    {

     

        // using queryBuilder

 

        $data=[ 'name'=>$this->request->getVar('name'),

                'email'=>$this->request->getVar('email'),

                'password'=>$this->request->getVar('password')

 

              ];

 

        $db_connection=\Config\Database::connect();

        $table=$db_connection->table('users');
        $table->insert($data);
        // using model
        $data_insert=new AdminModel();

        $data_insert->insert($data);          

    }

}
