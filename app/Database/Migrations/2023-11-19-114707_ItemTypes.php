<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ItemTypes extends Migration
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
            'type_id' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'type_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['type_id']);
        $this->forge->createTable('item_types');
    
    }

    public function down()
    {
        $this->forge->dropTable('item_types'); 

    }
}
