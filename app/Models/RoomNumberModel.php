<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomNumberModel extends Model
{
    protected $table            = 'room_numbers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'room_id',
        'room_number',
        'display_name',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActiveByRoomId(int $roomId)
    {
        return $this->where('room_id', $roomId)
                    ->where('is_active', 1)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    public function getAllWithRoomName()
    {
        return $this->select('room_numbers.*, rooms.name as room_name, rooms.code as room_code')
                    ->join('rooms', 'rooms.id = room_numbers.room_id')
                    ->orderBy('rooms.name', 'ASC')
                    ->orderBy('room_numbers.id', 'ASC')
                    ->findAll();
    }
}
