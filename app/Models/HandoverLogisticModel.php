<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverLogisticModel extends Model
{
    protected $table            = 'handover_logistics';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['handover_id', 'logistic_item_id', 'quantity', 'notes'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByHandoverId(int $handoverId)
    {
        return $this->select('handover_logistics.*, logistic_items.name as item_name')
                    ->join('logistic_items', 'logistic_items.id = handover_logistics.logistic_item_id')
                    ->where('handover_logistics.handover_id', $handoverId)
                    ->orderBy('logistic_items.sort_order', 'ASC')
                    ->findAll();
    }
}
