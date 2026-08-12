<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventoryItemModel;

class InventoryItemController extends BaseController
{
    protected InventoryItemModel $itemModel;

    public function __construct()
    {
        $this->itemModel = new InventoryItemModel();
    }

    public function index()
    {
        $items = $this->itemModel->getAllWithCategory();

        return view('admin/inventory_items/index', [
            'title' => 'Master Inventaris Barang',
            'items' => $items,
        ]);
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'unit'       => 'required|max_length[30]',
            'sort_order' => 'numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Lengkapi seluruh field wajib master inventaris.');
        }

        $this->itemModel->insert([
            'name'       => $this->request->getPost('name'),
            'unit'       => $this->request->getPost('unit'),
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/inventory-items'))->with('success', 'Master inventaris baru berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->to(base_url('admin/inventory-items'))->with('error', 'Item tidak ditemukan.');
        }

        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'unit'       => 'required|max_length[30]',
            'sort_order' => 'numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali inputan Anda.');
        }

        $this->itemModel->update($id, [
            'name'       => $this->request->getPost('name'),
            'unit'       => $this->request->getPost('unit'),
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/inventory-items'))->with('success', 'Master inventaris berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->to(base_url('admin/inventory-items'))->with('error', 'Item tidak ditemukan.');
        }

        try {
            $this->itemModel->delete($id);
            return redirect()->to(base_url('admin/inventory-items'))->with('success', 'Item inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/inventory-items'))->with('error', 'Gagal menghapus item karena masih digunakan pada standar kamar.');
        }
    }
}
