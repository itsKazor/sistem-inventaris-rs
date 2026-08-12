<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverModel extends Model
{
    protected $table            = 'handovers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'handover_number',
        'room_id',
        'room_number_id',
        'handover_date',
        'handover_time',
        'sender_name',
        'sender_position',
        'receiver_name',
        'receiver_position',
        'notes',
        'patient_photo_path',
        'sender_signature_path',
        'receiver_signature_path',
        'acknowledgement_signature_path',
        'statement_confirmed',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function generateNumber(): string
    {
        $prefix = 'STR-' . date('Ymd') . '-';

        $lastRecord = $this->like('handover_number', $prefix, 'after')
                           ->orderBy('id', 'DESC')
                           ->first();

        if ($lastRecord && !empty($lastRecord['handover_number'])) {
            $lastNumStr = substr($lastRecord['handover_number'], -5);
            $lastNum = (int) $lastNumStr;
            $newNum = $lastNum + 1;
        } else {
            $newNum = 1;
        }

        return $prefix . str_pad((string) $newNum, 5, '0', STR_PAD_LEFT);
    }

    public function getDetailById(int $id)
    {
        return $this->select('handovers.*, rooms.name as room_name, rooms.code as room_code, room_numbers.display_name as room_number_name, room_numbers.room_number, users.name as reviewer_name')
                    ->join('rooms', 'rooms.id = handovers.room_id')
                    ->join('room_numbers', 'room_numbers.id = handovers.room_number_id')
                    ->join('users', 'users.id = handovers.reviewed_by', 'left')
                    ->where('handovers.id', $id)
                    ->first();
    }
}
