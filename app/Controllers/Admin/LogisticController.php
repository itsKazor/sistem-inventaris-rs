<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogisticItemModel;
use App\Models\HandoverLogisticModel;

class LogisticController extends BaseController
{
    protected $logisticModel;

    public function __construct()
    {
        $this->logisticModel = new LogisticItemModel();
    }

    public function index()
    {
        $logistics = $this->logisticModel->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/logistics/index', [
            'title'        => 'Master Logistik',
            'page_heading' => 'Kelola Master Persediaan & Logistik',
            'logistics'    => $logistics,
        ]);
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'sort_order' => 'numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: Cek kembali inputan Anda.');
        }

        $this->logisticModel->insert([
            'name'       => $this->request->getPost('name'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/logistics')->with('success', 'Item logistik berhasil ditambahkan.');
    }

    public function update($id)
    {
        $logistic = $this->logisticModel->find($id);
        if (!$logistic) {
            return redirect()->to('/admin/logistics')->with('error', 'Item logistik tidak ditemukan.');
        }

        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'sort_order' => 'numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui: Cek kembali inputan Anda.');
        }

        $this->logisticModel->update($id, [
            'name'       => $this->request->getPost('name'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/logistics')->with('success', 'Item logistik berhasil diperbarui.');
    }

    public function delete($id)
    {
        $handoverLogisticModel = new HandoverLogisticModel();
        $usedCount = $handoverLogisticModel->where('logistic_item_id', $id)->countAllResults();

        if ($usedCount > 0) {
            return redirect()->to('/admin/logistics')->with('error', 'Item logistik ini tidak dapat dihapus karena sudah pernah diisi dalam transaksi serah terima. Anda dapat menonaktifkannya.');
        }

        $this->logisticModel->delete($id);
        return redirect()->to('/admin/logistics')->with('success', 'Item logistik berhasil dihapus.');
    }
}
