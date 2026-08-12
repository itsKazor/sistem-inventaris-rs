<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HandoverInventoryItemModel;
use App\Models\HandoverModel;
use App\Models\RoomModel;
use App\Models\RoomNumberModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $handoverModel              = new HandoverModel();
        $handoverInventoryItemModel = new HandoverInventoryItemModel();
        $roomModel                  = new RoomModel();
        $roomNumberModel            = new RoomNumberModel();

        // 1. Statistics Cards Data
        $totalRooms    = $roomModel->countAllResults();
        $totalRoomNums = $roomNumberModel->countAllResults();

        $today         = date('Y-m-d');
        $handoversToday = $handoverModel->where('handover_date', $today)->countAllResults();

        $monthStart     = date('Y-m-01');
        $monthEnd       = date('Y-m-t');
        $handoversMonth = $handoverModel->where('handover_date >=', $monthStart)
                                        ->where('handover_date <=', $monthEnd)
                                        ->countAllResults();

        $pendingReview  = $handoverModel->where('status', 'submitted')->countAllResults();

        // Count problem items
        $damagedCount    = $handoverInventoryItemModel->where('condition_status', 'damaged')->countAllResults();
        $needRepairCount = $handoverInventoryItemModel->where('condition_status', 'need_repair')->countAllResults();
        $shortageCount   = $handoverInventoryItemModel->whereIn('condition_status', ['shortage', 'not_available'])->countAllResults();

        // 2. Recent Transactions (5 Latest)
        $recentHandovers = $handoverModel->select('handovers.*, rooms.name as room_name, room_numbers.display_name as room_number_name')
                                         ->join('rooms', 'rooms.id = handovers.room_id')
                                         ->join('room_numbers', 'room_numbers.id = handovers.room_number_id')
                                         ->orderBy('handovers.id', 'DESC')
                                         ->findAll(5);

        // 3. Issue Summary by Inventory Name
        $db = \Config\Database::connect();
        $issueSummary = $db->table('handover_inventory_items')
                           ->select('inventory_name_snapshot, 
                                     COUNT(id) as total_issues,
                                     SUM(CASE WHEN condition_status = "damaged" THEN 1 ELSE 0 END) as damaged_cnt,
                                     SUM(CASE WHEN condition_status = "need_repair" THEN 1 ELSE 0 END) as need_repair_cnt,
                                     SUM(CASE WHEN condition_status IN ("shortage", "not_available") THEN 1 ELSE 0 END) as shortage_cnt')
                           ->whereIn('condition_status', ['damaged', 'need_repair', 'shortage', 'not_available'])
                           ->groupBy('inventory_name_snapshot')
                           ->orderBy('total_issues', 'DESC')
                           ->get(5)
                           ->getResultArray();

        return view('admin/dashboard/index', [
            'title'           => 'Dashboard Utama',
            'totalRooms'      => $totalRooms,
            'totalRoomNums'   => $totalRoomNums,
            'handoversToday'  => $handoversToday,
            'handoversMonth'  => $handoversMonth,
            'pendingReview'   => $pendingReview,
            'damagedCount'    => $damagedCount,
            'needRepairCount' => $needRepairCount,
            'shortageCount'   => $shortageCount,
            'recentHandovers' => $recentHandovers,
            'issueSummary'    => $issueSummary,
        ]);
    }
}
