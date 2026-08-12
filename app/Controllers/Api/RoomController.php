<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\RoomNumberModel;

class RoomController extends BaseController
{
    public function getRoomNumbers(int $roomId)
    {
        $roomNumberModel = new RoomNumberModel();
        $roomNumbers = $roomNumberModel->getActiveByRoomId($roomId);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $roomNumbers,
        ]);
    }
}
