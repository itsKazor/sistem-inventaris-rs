<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ChecklistSeeder extends Seeder
{
    public function run()
    {
        // Truncate existing categories & items to replace with updated list
        $this->db->disableForeignKeyChecks();
        $this->db->table('handover_checklist_items')->truncate();
        $this->db->table('checklist_items')->truncate();
        $this->db->table('checklist_categories')->truncate();
        $this->db->enableForeignKeyChecks();

        $categoriesWithItems = [
            'Fasilitas & Perabot Kamar' => [
                'Tempat Tidur + Standar Infus',
                'Tilam (Kasur)',
                'Bantal',
                'Lemari',
                'Meja Makan (Overbed Table)',
                'Kursi Plastik',
                'Dispenser + Meja Dispenser',
                'Tirai Pembatas',
            ],
            'Linen & Perlengkapan' => [
                'Selimut',
                'Laken (Sprei)',
                'Sarung Bantal',
            ],
            'Elektronik & Sanitasi Ruang' => [
                'AC',
                'Kebersihan Ruang',
                'Lampu & Instalasi Listrik',
                'Wastafel & Sanitasi (Toilet)',
            ],
        ];

        $catOrder = 1;
        foreach ($categoriesWithItems as $catName => $items) {
            $this->db->table('checklist_categories')->insert([
                'name'       => $catName,
                'sort_order' => $catOrder++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $categoryId = $this->db->insertID();

            $itemOrder = 1;
            foreach ($items as $itemName) {
                $this->db->table('checklist_items')->insert([
                    'category_id' => $categoryId,
                    'name'        => $itemName,
                    'sort_order'  => $itemOrder++,
                    'is_active'   => 1,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
