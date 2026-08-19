<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_number extends AdminOnly_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Room_number_model');
        $this->load->model('Room_model');
    }

    public function index() {
        $data['title'] = 'Master Data Kamar / Nomor Ruangan';
        $data['room_numbers'] = $this->Room_number_model->get_all(null, false);
        $data['rooms'] = $this->Room_model->get_all(true);

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/room_numbers/index', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function store() {
        $room_id = $this->input->post('room_id');
        $room_number = trim($this->input->post('room_number'));
        $display_name = trim($this->input->post('display_name'));
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (!empty($room_id) && !empty($display_name)) {
            $this->Room_number_model->insert(array(
                'room_id' => $room_id,
                'room_number' => $room_number ?: '1',
                'display_name' => $display_name,
                'is_active' => $is_active
            ));
            $this->session->set_flashdata('success', 'Kamar berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Ruangan dan Nama Tampilan Kamar wajib diisi!');
        }
        redirect('admin/room-numbers');
    }

    public function update($id) {
        $room_id = $this->input->post('room_id');
        $room_number = trim($this->input->post('room_number'));
        $display_name = trim($this->input->post('display_name'));
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (!empty($room_id) && !empty($display_name)) {
            $this->Room_number_model->update($id, array(
                'room_id' => $room_id,
                'room_number' => $room_number ?: '1',
                'display_name' => $display_name,
                'is_active' => $is_active
            ));
            $this->session->set_flashdata('success', 'Data kamar berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Ruangan dan Nama Tampilan Kamar wajib diisi!');
        }
        redirect('admin/room-numbers');
    }

    public function delete($id) {
        if ($this->Room_number_model->delete($id)) {
            $this->session->set_flashdata('success', 'Kamar berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kamar!');
        }
        redirect('admin/room-numbers');
    }
}
