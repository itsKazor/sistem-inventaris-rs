<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryItemModel extends Model
{
    protected $table            = 'inventory_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'name',
        'unit',
        'sort_order',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllWithCategory()
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }

    public function getActiveGroupedByCategory()
    {
        $items = $this->where('is_active', 1)
                      ->orderBy('sort_order', 'ASC')
                      ->findAll();

        return [
            [
                'category_id'   => 1,
                'category_name' => 'Inventaris Kamar',
                'items'         => $items,
            ]
        ];
    }
}
