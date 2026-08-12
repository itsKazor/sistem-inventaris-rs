<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHandoverInventoryItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'handover_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'inventory_item_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'inventory_name_snapshot' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'inventory_unit_snapshot' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => 'unit',
            ],
            'standard_quantity_snapshot' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'actual_quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'difference_quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'condition_status' => [
                'type'       => 'ENUM',
                'constraint' => ['good', 'damaged', 'need_repair', 'shortage', 'not_available'],
                'default'    => 'good',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('handover_id', 'handovers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('inventory_item_id', 'inventory_items', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('handover_inventory_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('handover_inventory_items', true);
    }
}
