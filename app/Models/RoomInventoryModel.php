<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomInventoryModel extends Model
{
    protected $table            = 'room_inventories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'room_number_id',
        'inventory_item_id',
        'standard_quantity',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getStandardsByRoomNumberId(int $roomNumberId)
    {
        return $this->select('room_inventories.*, inventory_items.name as inventory_name, inventory_items.unit')
                    ->join('inventory_items', 'inventory_items.id = room_inventories.inventory_item_id')
                    ->where('room_inventories.room_number_id', $roomNumberId)
                    ->where('inventory_items.is_active', 1)
                    ->orderBy('inventory_items.sort_order', 'ASC')
                    ->findAll();
    }

    public function getGroupedStandardsByRoomNumberId(int $roomNumberId)
    {
        $items = $this->getStandardsByRoomNumberId($roomNumberId);

        return [
            [
                'category_id'   => 1,
                'category_name' => 'Inventaris Kamar',
                'items'         => $items,
            ]
        ];
    }
}
