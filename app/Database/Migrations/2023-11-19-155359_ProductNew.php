<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductNew extends Migration
{
    protected $group = 'default';
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
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'product_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'item_type' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['product_id']);
        $this->forge->createTable('products');
    }
    public function down()
    {
        $this->forge->dropTable('products'); 
    }
}
