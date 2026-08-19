<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends AdminOnly_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Room_model');
    }

    public function index() {
        $data['title'] = 'Master Data Ruangan';
        $data['rooms'] = $this->Room_model->get_all(false);

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/rooms/index', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function store() {
        $name = trim($this->input->post('name'));
        $code = trim($this->input->post('code'));
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (!empty($name) && !empty($code)) {
            $this->Room_model->insert(array(
                'name' => $name,
                'code' => strtoupper($code),
                'is_active' => $is_active
            ));
            $this->session->set_flashdata('success', 'Ruangan berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Nama dan Kode ruangan wajib diisi!');
        }
        redirect('admin/rooms');
    }

    public function update($id) {
        $name = trim($this->input->post('name'));
        $code = trim($this->input->post('code'));
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (!empty($name) && !empty($code)) {
            $this->Room_model->update($id, array(
                'name' => $name,
                'code' => strtoupper($code),
                'is_active' => $is_active
            ));
            $this->session->set_flashdata('success', 'Data ruangan berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Nama dan Kode ruangan wajib diisi!');
        }
        redirect('admin/rooms');
    }

    public function delete($id) {
        if ($this->Room_model->delete($id)) {
            $this->session->set_flashdata('success', 'Ruangan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus ruangan!');
        }
        redirect('admin/rooms');
    }
}
