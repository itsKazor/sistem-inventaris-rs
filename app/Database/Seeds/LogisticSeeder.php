<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LogisticSeeder extends Seeder
{
    public function run()
    {
        $logistics = [
            'Obat-obatan',
            'Alkes / BHP',
            'ATK',
            'Bahan Habis Pakai',
            'Linen / Laundry',
            'Lain-lain',
        ];

        $sortOrder = 1;
        foreach ($logistics as $item) {
            $this->db->table('logistic_items')->insert([
                'name'       => $item,
                'sort_order' => $sortOrder++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
