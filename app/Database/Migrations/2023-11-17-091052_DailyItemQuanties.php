<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DailyItemQuanties extends Migration
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
            'old_quantity' => [
                'type'           => 'INT',
                'constraint'     => '0',
            ],
            'new_quantity' => [
                'type'           => 'INT',
                'constraint'     => '0',
            ],
            'total_quantity' => [
                'type'           => 'INT',
                'constraint'     => '0',
            ],
            'action_type' => [
                'type'           => 'VARCHAR',
                'constraint'     => 64,
            ],
            'updated_at' => [
                'type'        => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('daily_quantities');
    }

    public function down()
    {
        $this->forge->dropTable('daily_quantities'); 
    
    }
}
