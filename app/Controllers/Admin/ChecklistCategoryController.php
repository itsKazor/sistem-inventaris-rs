<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ChecklistCategoryModel;
use App\Models\ChecklistItemModel;

class ChecklistCategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new ChecklistCategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/checklist_categories/index', [
            'title'        => 'Kategori Checklist',
            'page_heading' => 'Kelola Kategori Checklist',
            'categories'   => $categories,
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

        $this->categoryModel->insert([
            'name'       => $this->request->getPost('name'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/checklist-categories')->with('success', 'Kategori checklist berhasil ditambahkan.');
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/checklist-categories')->with('error', 'Kategori tidak ditemukan.');
        }

        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'sort_order' => 'numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui: Cek kembali inputan Anda.');
        }

        $this->categoryModel->update($id, [
            'name'       => $this->request->getPost('name'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/checklist-categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $itemModel = new ChecklistItemModel();
        $itemCount = $itemModel->where('category_id', $id)->countAllResults();

        if ($itemCount > 0) {
            return redirect()->to('/admin/checklist-categories')->with('error', 'Kategori ini tidak dapat dihapus karena masih memiliki item checklist. Silakan hapus item terlebih dahulu atau nonaktifkan kategori.');
        }

        $this->categoryModel->delete($id);
        return redirect()->to('/admin/checklist-categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
