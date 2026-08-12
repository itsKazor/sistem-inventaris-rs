<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomModel;

class RoomController extends BaseController
{
    protected RoomModel $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
    }

    public function index()
    {
        $rooms = $this->roomModel->orderBy('name', 'ASC')->findAll();

        return view('admin/rooms/index', [
            'title' => 'Master Data Ruangan',
            'rooms' => $rooms,
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'code' => 'required|min_length[2]|max_length[20]|is_unique[rooms.code]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan ruang. Pastikan nama dan kode unik (min 2 karakter).');
        }

        $this->roomModel->insert([
            'name'      => $this->request->getPost('name'),
            'code'      => strtoupper($this->request->getPost('code')),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/rooms'))->with('success', 'Ruang baru berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return redirect()->to(base_url('admin/rooms'))->with('error', 'Ruang tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'code' => "required|min_length[2]|max_length[20]|is_unique[rooms.code,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate ruang. Periksa kembali inputan Anda.');
        }

        $this->roomModel->update($id, [
            'name'      => $this->request->getPost('name'),
            'code'      => strtoupper($this->request->getPost('code')),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/rooms'))->with('success', 'Data ruang berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return redirect()->to(base_url('admin/rooms'))->with('error', 'Ruang tidak ditemukan.');
        }

        try {
            $this->roomModel->delete($id);
            return redirect()->to(base_url('admin/rooms'))->with('success', 'Ruang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/rooms'))->with('error', 'Gagal menghapus ruang karena masih memiliki data terkait (kamar/serah terima).');
        }
    }
}
