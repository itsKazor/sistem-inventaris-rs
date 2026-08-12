<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();
        $this->db->table('room_inventories')->truncate();
        $this->db->table('inventory_items')->truncate();
        $this->db->enableForeignKeyChecks();

        // Exact 15 items requested by the user
        $items = [
            ['name' => 'Tempat Tidur', 'unit' => 'unit'],
            ['name' => 'Tilam', 'unit' => 'unit'],
            ['name' => 'Bantal', 'unit' => 'buah'],
            ['name' => 'Lemari', 'unit' => 'unit'],
            ['name' => 'Meja Makan', 'unit' => 'unit'],
            ['name' => 'Kursi', 'unit' => 'buah'],
            ['name' => 'Tirai Pembatas', 'unit' => 'set'],
            ['name' => 'Selimut', 'unit' => 'lembar'],
            ['name' => 'Laken (Sprei)', 'unit' => 'lembar'],
            ['name' => 'Sarung Bantal', 'unit' => 'lembar'],
            ['name' => 'AC', 'unit' => 'unit'],
            ['name' => 'TV', 'unit' => 'unit'],
            ['name' => 'Remote AC', 'unit' => 'buah'],
            ['name' => 'Remote TV', 'unit' => 'buah'],
            ['name' => 'Dispenser + Meja', 'unit' => 'unit'],
        ];

        $sortOrder = 1;
        foreach ($items as $item) {
            $this->db->table('inventory_items')->insert([
                'name'        => $item['name'],
                'unit'        => $item['unit'],
                'sort_order'  => $sortOrder++,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
