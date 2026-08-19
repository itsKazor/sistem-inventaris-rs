<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_inventory extends AdminOnly_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Room_number_model');
        $this->load->model('Inventory_item_model');
        $this->load->model('Room_inventory_model');
        $this->load->model('Room_model');
    }

    public function index() {
        $data['title'] = 'Pengaturan Standar Inventaris Kamar';
        $data['room_numbers'] = $this->Room_number_model->get_all(null, true);

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/room_inventories/index', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function manage($room_number_id) {
        $data['room_number'] = $this->Room_number_model->get_by_id($room_number_id);
        if (!$data['room_number']) {
            show_404();
        }

        $data['title'] = 'Atur Barang: ' . $data['room_number']['room_name'] . ' - ' . $data['room_number']['display_name'];
        $data['all_items'] = $this->Inventory_item_model->get_all(true);
        $data['existing_inventories'] = $this->Room_inventory_model->get_by_room_number($room_number_id);

        $data['existing_qty'] = array();
        foreach ($data['existing_inventories'] as $ex) {
            $data['existing_qty'][$ex['inventory_item_id']] = $ex['standard_quantity'];
        }

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/room_inventories/manage', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function save($room_number_id) {
        $items = $this->input->post('items');
        if ($this->Room_inventory_model->save_room_inventories($room_number_id, $items)) {
            $this->session->set_flashdata('success', 'Standar barang kamar berhasil disimpan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan standar barang!');
        }
        redirect('admin/room-inventories/' . $room_number_id);
    }
}
