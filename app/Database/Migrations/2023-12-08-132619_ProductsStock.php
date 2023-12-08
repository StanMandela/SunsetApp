<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductsStock extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'quantity' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'latest_action' => [
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'updated_on' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['product_id']);
        $this->forge->createTable('products_stock');
    }

    public function down()
    {
        $this->forge->dropTable('products_stock'); 

    }
}
