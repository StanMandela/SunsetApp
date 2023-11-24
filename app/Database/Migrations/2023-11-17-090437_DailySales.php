<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DailySales extends Migration
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
                'constraint'     => '0',
            ],
            'price' => [
                'type'           => 'INT',
                'constraint'     => '0',
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
        $this->forge->createTable('daily_sales');
    }

    public function down()
    {
        $this->forge->dropTable('daily_sales'); 
    
    }
}
