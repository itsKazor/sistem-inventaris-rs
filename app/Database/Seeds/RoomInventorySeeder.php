<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoomInventorySeeder extends Seeder
{
    public function run()
    {
        $this->db->table('room_inventories')->truncate();

        $roomNumbers = $this->db->table('room_numbers')->get()->getResultArray();
        $inventoryItems = $this->db->table('inventory_items')->get()->getResultArray();

        $itemMap = [];
        foreach ($inventoryItems as $item) {
            $itemMap[$item['name']] = $item['id'];
        }

        foreach ($roomNumbers as $rNum) {
            $is4BedRoom = ($rNum['display_name'] === 'Kamar 7');
            $bedQty = $is4BedRoom ? 4 : 2;

            $standards = [
                'Tempat Tidur'     => $bedQty,
                'Tilam'            => $bedQty,
                'Bantal'           => $bedQty,
                'Lemari'           => $bedQty,
                'Meja Makan'       => $bedQty,
                'Kursi'            => $is4BedRoom ? 2 : 1,
                'Tirai Pembatas'   => $bedQty,
                'Selimut'          => $bedQty,
                'Laken (Sprei)'    => $bedQty,
                'Sarung Bantal'    => $bedQty,
                'AC'               => 1,
                'TV'               => 1,
                'Remote AC'        => 1,
                'Remote TV'        => 1,
                'Dispenser + Meja' => 1,
            ];

            foreach ($standards as $itemName => $qty) {
                if (isset($itemMap[$itemName])) {
                    $this->db->table('room_inventories')->insert([
                        'room_number_id'    => $rNum['id'],
                        'inventory_item_id' => $itemMap[$itemName],
                        'standard_quantity' => $qty,
                        'created_at'        => date('Y-m-d H:i:s'),
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }
}
