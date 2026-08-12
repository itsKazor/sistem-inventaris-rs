<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHandoversTable extends Migration
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
            'handover_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'room_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'room_number_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'handover_date' => [
                'type' => 'DATE',
            ],
            'handover_time' => [
                'type' => 'TIME',
            ],
            'sender_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'sender_position' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'receiver_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'receiver_position' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sender_signature_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'receiver_signature_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'acknowledgement_signature_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'statement_confirmed' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['submitted', 'reviewed'],
                'default'    => 'submitted',
            ],
            'reviewed_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'reviewed_at' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('room_number_id', 'room_numbers', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('reviewed_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('handovers', true);
    }

    public function down()
    {
        $this->forge->dropTable('handovers', true);
    }
}
