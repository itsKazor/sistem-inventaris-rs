<?php

namespace App\Models;

use CodeIgniter\Model;

class ChecklistItemModel extends Model
{
    protected $table            = 'checklist_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['category_id', 'name', 'sort_order', 'is_active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'category_id' => 'required|numeric',
        'name'        => 'required|min_length[2]|max_length[100]',
    ];

    public function getActiveGroupedByCategory()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('checklist_categories cat');
        $builder->select('cat.id as category_id, cat.name as category_name, item.id as item_id, item.name as item_name, item.sort_order');
        $builder->join('checklist_items item', 'item.category_id = cat.id');
        $builder->where('cat.is_active', 1);
        $builder->where('item.is_active', 1);
        $builder->orderBy('cat.sort_order', 'ASC');
        $builder->orderBy('item.sort_order', 'ASC');

        $query = $builder->get();
        $results = $query->getResultArray();

        $grouped = [];
        foreach ($results as $row) {
            $catId = $row['category_id'];
            if (!isset($grouped[$catId])) {
                $grouped[$catId] = [
                    'category_id'   => $catId,
                    'category_name' => $row['category_name'],
                    'items'         => [],
                ];
            }
            $grouped[$catId]['items'][] = [
                'id'         => $row['item_id'],
                'name'       => $row['item_name'],
                'sort_order' => $row['sort_order'],
            ];
        }

        return array_values($grouped);
    }
}
