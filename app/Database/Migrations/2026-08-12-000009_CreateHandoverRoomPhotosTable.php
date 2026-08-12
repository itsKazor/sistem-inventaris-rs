<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHandoverRoomPhotosTable extends Migration
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
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'caption' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
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
        $this->forge->createTable('handover_room_photos', true);
    }

    public function down()
    {
        $this->forge->dropTable('handover_room_photos', true);
    }
}
