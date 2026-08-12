<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryCategoryModel extends Model
{
    protected $table            = 'inventory_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'name',
        'sort_order',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActiveCategories()
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
    }
}
