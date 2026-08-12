<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverRoomPhotoModel extends Model
{
    protected $table            = 'handover_room_photos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'handover_id',
        'file_path',
        'caption',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPhotosByHandoverId(int $handoverId)
    {
        return $this->where('handover_id', $handoverId)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
