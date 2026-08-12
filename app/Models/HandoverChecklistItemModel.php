<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverChecklistItemModel extends Model
{
    protected $table            = 'handover_checklist_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['handover_id', 'checklist_item_id', 'quantity', 'condition_status', 'notes'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getItemsByHandoverId(int $handoverId)
    {
        return $this->select('handover_checklist_items.*, checklist_items.name as item_name, checklist_categories.name as category_name, checklist_categories.id as category_id')
                    ->join('checklist_items', 'checklist_items.id = handover_checklist_items.checklist_item_id')
                    ->join('checklist_categories', 'checklist_categories.id = checklist_items.category_id')
                    ->where('handover_checklist_items.handover_id', $handoverId)
                    ->orderBy('checklist_categories.sort_order', 'ASC')
                    ->orderBy('checklist_items.sort_order', 'ASC')
                    ->findAll();
    }

    public function getProblematicItemsSummary()
    {
        return $this->select('checklist_items.name as item_name, COUNT(handover_checklist_items.id) as total_issues')
                    ->join('checklist_items', 'checklist_items.id = handover_checklist_items.checklist_item_id')
                    ->whereIn('handover_checklist_items.condition_status', ['damaged', 'need_repair'])
                    ->groupBy('checklist_items.id')
                    ->orderBy('total_issues', 'DESC')
                    ->findAll(5);
    }
}
