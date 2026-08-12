<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventoryItemModel;
use App\Models\RoomInventoryModel;
use App\Models\RoomNumberModel;

class RoomInventoryController extends BaseController
{
    protected RoomInventoryModel $roomInventoryModel;
    protected RoomNumberModel $roomNumberModel;
    protected InventoryItemModel $inventoryItemModel;

    public function __construct()
    {
        $this->roomInventoryModel = new RoomInventoryModel();
        $this->roomNumberModel    = new RoomNumberModel();
        $this->inventoryItemModel = new InventoryItemModel();
    }

    public function index()
    {
        $roomNumbers = $this->roomNumberModel->getAllWithRoomName();

        // Attach count of standard items configured for each room
        foreach ($roomNumbers as &$rNum) {
            $standards = $this->roomInventoryModel->where('room_number_id', $rNum['id'])->findAll();
            $rNum['total_standards'] = count($standards);
            $rNum['total_items_qty']  = array_sum(array_column($standards, 'standard_quantity'));
        }

        return view('admin/room_inventories/index', [
            'title'       => 'Kelola Inventaris Standar Kamar',
            'roomNumbers' => $roomNumbers,
        ]);
    }

    public function manage(int $roomNumberId)
    {
        $roomNumberModel = new RoomNumberModel();
        $roomNumber = $roomNumberModel->select('room_numbers.*, rooms.name as room_name, rooms.code as room_code')
                                      ->join('rooms', 'rooms.id = room_numbers.room_id')
                                      ->where('room_numbers.id', $roomNumberId)
                                      ->first();

        if (!$roomNumber) {
            return redirect()->to(base_url('admin/room-inventories'))->with('error', 'Kamar tidak ditemukan.');
        }

        // Get all active inventory items grouped by category
        $groupedMasterItems = $this->inventoryItemModel->getActiveGroupedByCategory();

        // Get current existing standards for this room
        $existingStandards = $this->roomInventoryModel->where('room_number_id', $roomNumberId)->findAll();
        $standardsMap = [];
        foreach ($existingStandards as $std) {
            $standardsMap[$std['inventory_item_id']] = $std['standard_quantity'];
        }

        return view('admin/room_inventories/manage', [
            'title'              => 'Inventaris Standar: ' . $roomNumber['room_name'] . ' - ' . $roomNumber['display_name'],
            'roomNumber'         => $roomNumber,
            'groupedMasterItems' => $groupedMasterItems,
            'standardsMap'       => $standardsMap,
        ]);
    }

    public function save(int $roomNumberId)
    {
        $standardsInput = $this->request->getPost('standards') ?? [];

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Delete existing baseline standards for this room
            $this->roomInventoryModel->where('room_number_id', $roomNumberId)->delete();

            // Re-insert valid standard quantities
            foreach ($standardsInput as $itemId => $qty) {
                $qtyVal = (int) $qty;
                if ($qtyVal > 0) {
                    $this->roomInventoryModel->insert([
                        'room_number_id'    => $roomNumberId,
                        'inventory_item_id' => $itemId,
                        'standard_quantity' => $qtyVal,
                    ]);
                }
            }

            $db->transCommit();
            return redirect()->to(base_url('admin/room-inventories'))->with('success', 'Inventaris standar kamar berhasil diperbarui.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan inventaris standar kamar: ' . $e->getMessage());
        }
    }
}
