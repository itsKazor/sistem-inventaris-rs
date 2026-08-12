<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventoryItemModel;
use App\Models\RoomModel;
use App\Models\RoomNumberModel;

class ReportController extends BaseController
{
    public function issues()
    {
        $conditionStatus = $this->request->getGet('condition_status') ?? 'all';
        $roomId          = $this->request->getGet('room_id');
        $roomNumId       = $this->request->getGet('room_number_id');
        $inventoryId     = $this->request->getGet('inventory_id');
        $startDate       = $this->request->getGet('start_date');
        $endDate         = $this->request->getGet('end_date');

        $db = \Config\Database::connect();
        $builder = $db->table('handover_inventory_items')
                      ->select('handover_inventory_items.*, 
                                handovers.handover_number, handovers.handover_date, handovers.handover_time, handovers.sender_name, handovers.receiver_name,
                                rooms.name as room_name, room_numbers.display_name as room_number_name')
                      ->join('handovers', 'handovers.id = handover_inventory_items.handover_id')
                      ->join('rooms', 'rooms.id = handovers.room_id')
                      ->join('room_numbers', 'room_numbers.id = handovers.room_number_id');

        if ($conditionStatus !== 'all') {
            $builder->where('handover_inventory_items.condition_status', $conditionStatus);
        } else {
            $builder->whereIn('handover_inventory_items.condition_status', ['damaged', 'need_repair', 'shortage', 'not_available']);
        }

        if (!empty($roomId)) {
            $builder->where('handovers.room_id', $roomId);
        }

        if (!empty($roomNumId)) {
            $builder->where('handovers.room_number_id', $roomNumId);
        }

        if (!empty($inventoryId)) {
            $builder->where('handover_inventory_items.inventory_item_id', $inventoryId);
        }

        if (!empty($startDate)) {
            $builder->where('handovers.handover_date >=', $startDate);
        }

        if (!empty($endDate)) {
            $builder->where('handovers.handover_date <=', $endDate);
        }

        $issues = $builder->orderBy('handovers.handover_date', 'DESC')
                          ->orderBy('handovers.id', 'DESC')
                          ->get()
                          ->getResultArray();

        $roomModel       = new RoomModel();
        $roomNumberModel = new RoomNumberModel();
        $inventoryModel  = new InventoryItemModel();

        return view('admin/reports/issues', [
            'title'           => 'Laporan Barang Rusak / Kurang / Bermasalah',
            'issues'          => $issues,
            'rooms'           => $roomModel->getActiveRooms(),
            'roomNumbers'     => !empty($roomId) ? $roomNumberModel->getActiveByRoomId((int)$roomId) : [],
            'inventoryItems'  => $inventoryModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll(),
            'conditionStatus' => $conditionStatus,
            'filters'         => [
                'condition_status' => $conditionStatus,
                'room_id'          => $roomId,
                'room_number_id'   => $roomNumId,
                'inventory_id'     => $inventoryId,
                'start_date'       => $startDate,
                'end_date'         => $endDate,
            ],
        ]);
    }
}
