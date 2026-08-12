<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\RoomInventoryModel;

class RoomInventoryController extends BaseController
{
    public function getInventories(int $roomNumberId)
    {
        $roomInventoryModel = new RoomInventoryModel();
        $groupedInventories = $roomInventoryModel->getGroupedStandardsByRoomNumberId($roomNumberId);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $groupedInventories,
        ]);
    }
}
