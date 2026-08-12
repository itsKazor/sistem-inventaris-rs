<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPatientPhotoToHandovers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('handovers', [
            'patient_photo_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'notes',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('handovers', 'patient_photo_path');
    }
}
