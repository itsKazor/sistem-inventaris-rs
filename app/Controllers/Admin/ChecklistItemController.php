<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ChecklistCategoryModel;
use App\Models\ChecklistItemModel;
use App\Models\HandoverChecklistItemModel;

class ChecklistItemController extends BaseController
{
    protected $categoryModel;
    protected $itemModel;

    public function __construct()
    {
        $this->categoryModel = new ChecklistCategoryModel();
        $this->itemModel = new ChecklistItemModel();
    }

    public function index()
    {
        $items = $this->itemModel->select('checklist_items.*, checklist_categories.name as category_name')
                                 ->join('checklist_categories', 'checklist_categories.id = checklist_items.category_id')
                                 ->orderBy('checklist_categories.sort_order', 'ASC')
                                 ->orderBy('checklist_items.sort_order', 'ASC')
                                 ->findAll();

        $categories = $this->categoryModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/checklist_items/index', [
            'title'        => 'Item Checklist',
            'page_heading' => 'Kelola Master Item Checklist',
            'items'        => $items,
            'categories'   => $categories,
        ]);
    }

    public function store()
    {
        $rules = [
            'category_id' => 'required|numeric',
            'name'        => 'required|min_length[2]|max_length[100]',
            'sort_order'  => 'numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: Cek kembali inputan Anda.');
        }

        $this->itemModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/checklist-items')->with('success', 'Item checklist berhasil ditambahkan.');
    }

    public function update($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->to('/admin/checklist-items')->with('error', 'Item checklist tidak ditemukan.');
        }

        $rules = [
            'category_id' => 'required|numeric',
            'name'        => 'required|min_length[2]|max_length[100]',
            'sort_order'  => 'numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui: Cek kembali inputan Anda.');
        }

        $this->itemModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/checklist-items')->with('success', 'Item checklist berhasil diperbarui.');
    }

    public function delete($id)
    {
        $handoverChecklistModel = new HandoverChecklistItemModel();
        $usedCount = $handoverChecklistModel->where('checklist_item_id', $id)->countAllResults();

        if ($usedCount > 0) {
            return redirect()->to('/admin/checklist-items')->with('error', 'Item ini tidak dapat dihapus karena sudah pernah diisi dalam transaksi serah terima. Anda dapat menonaktifkannya.');
        }

        $this->itemModel->delete($id);
        return redirect()->to('/admin/checklist-items')->with('success', 'Item checklist berhasil dihapus.');
    }
}
