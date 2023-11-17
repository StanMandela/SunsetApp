<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Prices extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'item_id' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'price' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'from_date' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'to_date' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_on' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('prices');
    
    }

    public function down()
    {
        $this->forge->dropTable('prices'); 

    }
}
