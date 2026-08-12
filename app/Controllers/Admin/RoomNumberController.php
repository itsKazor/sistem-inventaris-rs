<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomModel;
use App\Models\RoomNumberModel;

class RoomNumberController extends BaseController
{
    protected RoomNumberModel $roomNumberModel;
    protected RoomModel $roomModel;

    public function __construct()
    {
        $this->roomNumberModel = new RoomNumberModel();
        $this->roomModel       = new RoomModel();
    }

    public function index()
    {
        $roomNumbers = $this->roomNumberModel->getAllWithRoomName();
        $rooms       = $this->roomModel->getActiveRooms();

        return view('admin/room_numbers/index', [
            'title'       => 'Master Data Kamar',
            'roomNumbers' => $roomNumbers,
            'rooms'       => $rooms,
        ]);
    }

    public function store()
    {
        $rules = [
            'room_id'      => 'required|numeric',
            'display_name' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Lengkapi seluruh field wajib untuk kamar.');
        }

        $displayName = $this->request->getPost('display_name');
        preg_match('/\d+/', $displayName, $matches);
        $numVal = $matches[0] ?? '1';

        $this->roomNumberModel->insert([
            'room_id'      => $this->request->getPost('room_id'),
            'room_number'  => $numVal,
            'display_name' => $displayName,
            'is_active'    => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/room-numbers'))->with('success', 'Kamar baru berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $roomNumber = $this->roomNumberModel->find($id);
        if (!$roomNumber) {
            return redirect()->to(base_url('admin/room-numbers'))->with('error', 'Kamar tidak ditemukan.');
        }

        $rules = [
            'room_id'      => 'required|numeric',
            'display_name' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Lengkapi seluruh field wajib.');
        }

        $displayName = $this->request->getPost('display_name');
        preg_match('/\d+/', $displayName, $matches);
        $numVal = $matches[0] ?? $roomNumber['room_number'];

        $this->roomNumberModel->update($id, [
            'room_id'      => $this->request->getPost('room_id'),
            'room_number'  => $numVal,
            'display_name' => $displayName,
            'is_active'    => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/room-numbers'))->with('success', 'Data kamar berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $roomNumber = $this->roomNumberModel->find($id);
        if (!$roomNumber) {
            return redirect()->to(base_url('admin/room-numbers'))->with('error', 'Kamar tidak ditemukan.');
        }

        try {
            $this->roomNumberModel->delete($id);
            return redirect()->to(base_url('admin/room-numbers'))->with('success', 'Kamar berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/room-numbers'))->with('error', 'Gagal menghapus kamar karena masih memiliki inventaris/transaksi terhubung.');
        }
    }
}
