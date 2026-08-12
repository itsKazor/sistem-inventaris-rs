<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverInventoryItemModel extends Model
{
    protected $table            = 'handover_inventory_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'handover_id',
        'inventory_item_id',
        'inventory_name_snapshot',
        'inventory_unit_snapshot',
        'standard_quantity_snapshot',
        'actual_quantity',
        'difference_quantity',
        'condition_status',
        'notes',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getItemsByHandoverId(int $handoverId)
    {
        return $this->where('handover_id', $handoverId)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }
}
