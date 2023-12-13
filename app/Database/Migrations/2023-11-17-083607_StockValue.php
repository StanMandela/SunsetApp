<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DailyBizValue extends Migration
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
            'date' => [
                'type'           => 'DATETIME',
                'null'           => false,
            ],
            'mpesa_balance' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'stock_value' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'purchases' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'lodging' => [
                'type'           => 'INT',
                'default'        => '0',
            ],
            'updated_on' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['date']);
        $this->forge->createTable('stock_value');
    }

    public function down()
    {
        $this->forge->dropTable('stock_value'); 

    }
}
