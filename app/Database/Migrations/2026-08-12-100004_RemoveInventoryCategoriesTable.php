<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveInventoryCategoriesTable extends Migration
{
    public function up()
    {
        // Drop foreign key if exists
        $this->db->query("ALTER TABLE inventory_items DROP FOREIGN KEY inventory_items_category_id_foreign");

        // Drop category_id column from inventory_items
        $this->forge->dropColumn('inventory_items', 'category_id');

        // Drop inventory_categories table completely
        $this->forge->dropTable('inventory_categories', true);
    }

    public function down()
    {
        // Recreate table if rollback
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('inventory_categories', true);
    }
}
