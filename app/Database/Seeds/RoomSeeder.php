<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            [
                'name'    => 'Melati',
                'code'    => 'MLT',
                'numbers' => ['Kamar 1', 'Kamar 2', 'Kamar 3', 'Kamar 4', 'Kamar 5', 'Kamar 6', 'Kamar 7'],
            ],
            [
                'name'    => 'Flamboyan',
                'code'    => 'FMB',
                'numbers' => ['Kamar 1', 'Kamar 2', 'Kamar 3', 'Kamar 4', 'Kamar 5'],
            ],
            [
                'name'    => 'PRB',
                'code'    => 'PRB',
                'numbers' => ['Kamar 1', 'Kamar 2', 'Kamar 3', 'Kamar 4'],
            ],
            [
                'name'    => 'Nusa Indah',
                'code'    => 'NSI',
                'numbers' => ['Kamar 1', 'Kamar 2', 'Kamar 3', 'Kamar 4', 'Kamar 5', 'Kamar 6'],
            ],
        ];

        foreach ($rooms as $roomData) {
            $this->db->table('rooms')->insert([
                'name'       => $roomData['name'],
                'code'       => $roomData['code'],
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $roomId = $this->db->insertID();

            foreach ($roomData['numbers'] as $idx => $numName) {
                // Parse number integer e.g. "Kamar 7" -> 7
                preg_match('/\d+/', $numName, $matches);
                $numVal = $matches[0] ?? ($idx + 1);

                $this->db->table('room_numbers')->insert([
                    'room_id'      => $roomId,
                    'room_number'  => $numVal,
                    'display_name' => $numName,
                    'is_active'    => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
