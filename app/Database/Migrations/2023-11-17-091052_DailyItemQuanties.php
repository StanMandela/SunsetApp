<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DailyItemQuanties extends Migration
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
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'quantity' => [
                'type'           => 'INT',
                'constraint'     => '0',
            ],
            'item_type' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'updated_date' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['item_id']);
        $this->forge->createTable('daily_quantities');
    }

    public function down()
    {
        $this->forge->dropTable('daily_quantities'); 
    
        //
    }
}
