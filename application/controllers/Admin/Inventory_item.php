<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_item extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Inventory_item_model');
    }

    public function index() {
        $data['title'] = 'Master Data Barang Inventaris';
        $data['items'] = $this->Inventory_item_model->get_all(false);

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/inventory_items/index', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function store() {
        $name = trim($this->input->post('name'));
        $unit = trim($this->input->post('unit'));
        $sort_order = (int) $this->input->post('sort_order');
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (!empty($name)) {
            $this->Inventory_item_model->insert(array(
                'name' => $name,
                'unit' => $unit ?: 'unit',
                'sort_order' => $sort_order,
                'is_active' => $is_active
            ));
            $this->session->set_flashdata('success', 'Barang inventaris berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Nama barang wajib diisi!');
        }
        redirect('admin/inventory-items');
    }

    public function update($id) {
        $name = trim($this->input->post('name'));
        $unit = trim($this->input->post('unit'));
        $sort_order = (int) $this->input->post('sort_order');
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (!empty($name)) {
            $this->Inventory_item_model->update($id, array(
                'name' => $name,
                'unit' => $unit ?: 'unit',
                'sort_order' => $sort_order,
                'is_active' => $is_active
            ));
            $this->session->set_flashdata('success', 'Data barang berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Nama barang wajib diisi!');
        }
        redirect('admin/inventory-items');
    }

    public function delete($id) {
        if ($this->Inventory_item_model->delete($id)) {
            $this->session->set_flashdata('success', 'Barang inventaris berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus barang inventaris!');
        }
        redirect('admin/inventory-items');
    }
}
