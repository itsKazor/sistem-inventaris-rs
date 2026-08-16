<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handover extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Room_model');
        $this->load->model('Room_number_model');
        $this->load->model('Inventory_item_model');
        $this->load->model('Room_inventory_model');
        $this->load->model('Handover_model');
    }

    public function index() {
        $data['title'] = 'FORM SERAH TERIMA & INVENTARIS KAMAR RSU CATHARINA 1914';
        $data['rooms'] = $this->Room_model->get_all(true);
        $data['currentDate'] = date('Y-m-d');
        $data['currentTime'] = date('H:i');

        $this->load->view('layouts/public_header', $data);
        $this->load->view('handovers/form', $data);
        $this->load->view('layouts/public_footer', $data);
    }

    public function save() {
        if ($this->input->method() !== 'post') {
            redirect('serah-terima');
        }

        $room_id = $this->input->post('room_id');
        $room_number_id = $this->input->post('room_number_id');
        $handover_date = $this->input->post('handover_date');
        $handover_time = $this->input->post('handover_time');
        $sender_name = trim($this->input->post('sender_name'));
        $sender_position = trim($this->input->post('sender_position'));
        $receiver_name = trim($this->input->post('receiver_name'));
        $receiver_position = trim($this->input->post('receiver_position'));
        $notes = trim($this->input->post('notes'));
        $statement_confirmed = $this->input->post('statement') ? 1 : 0;

        if (empty($room_id) || empty($room_number_id) || empty($sender_name) || empty($receiver_name)) {
            $this->session->set_flashdata('error', 'Mohon lengkapi semua data wajib!');
            redirect('serah-terima');
        }

        // Process patient photo from camera base64 data or file upload
        $patient_photo_path = $this->_save_base64_image($this->input->post('patient_photo_data'), 'patients', 'patient');
        if (!$patient_photo_path && !empty($_FILES['patient_photo']['name'])) {
            $upload_dir = FCPATH . 'uploads/patients/';
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0777, true);
            }
            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 5120;
            $config['file_name']     = 'patient_' . time() . '_' . substr(md5(mt_rand()), 0, 8);

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('patient_photo')) {
                $upload_data = $this->upload->data();
                $patient_photo_path = 'uploads/patients/' . $upload_data['file_name'];
            }
        }

        // Process Signatures
        $sender_sig_path = $this->_save_base64_image($this->input->post('signature_data_sender'), 'signatures', 'sig_sender');
        $receiver_sig_path = $this->_save_base64_image($this->input->post('signature_data_receiver'), 'signatures', 'sig_receiver');
        $head_sig_path = $this->_save_base64_image($this->input->post('signature_data_head'), 'signatures', 'sig_head');

        $handover_data = array(
            'room_id' => $room_id,
            'room_number_id' => $room_number_id,
            'handover_date' => $handover_date ?: date('Y-m-d'),
            'handover_time' => $handover_time ?: date('H:i:s'),
            'sender_name' => $sender_name,
            'sender_position' => $sender_position,
            'receiver_name' => $receiver_name,
            'receiver_position' => $receiver_position,
            'notes' => $notes,
            'patient_photo_path' => $patient_photo_path,
            'sender_signature_path' => $sender_sig_path,
            'receiver_signature_path' => $receiver_sig_path,
            'acknowledgement_signature_path' => $head_sig_path,
            'statement_confirmed' => $statement_confirmed,
            'status' => 'submitted'
        );

        // Process items
        $actual_quantities = $this->input->post('actual_quantity');
        $conditions = $this->input->post('condition');
        $inventory_notes = $this->input->post('inventory_notes');

        $handover_items = array();
        if (is_array($actual_quantities)) {
            foreach ($actual_quantities as $item_id => $act_qty) {
                $inventory_item = $this->Inventory_item_model->get_by_id($item_id);
                if ($inventory_item) {
                    $std_qty = 1;
                    // Find standard quantity for this room_number_id if configured
                    $room_inv = $this->db->get_where('room_inventories', array('room_number_id' => $room_number_id, 'inventory_item_id' => $item_id))->row_array();
                    if ($room_inv) {
                        $std_qty = (int) $room_inv['standard_quantity'];
                    }

                    $actual_qty = (int) $act_qty;
                    $diff_qty = $actual_qty - $std_qty;
                    $cond = $conditions[$item_id] ?? 'good';
                    $item_note = trim($inventory_notes[$item_id] ?? '');

                    $handover_items[] = array(
                        'inventory_item_id' => $item_id,
                        'inventory_name_snapshot' => $inventory_item['name'],
                        'inventory_unit_snapshot' => $inventory_item['unit'],
                        'standard_quantity_snapshot' => $std_qty,
                        'actual_quantity' => $actual_qty,
                        'difference_quantity' => $diff_qty,
                        'condition_status' => $cond,
                        'notes' => $item_note
                    );
                }
            }
        }

        $handover_id = $this->Handover_model->save_handover($handover_data, $handover_items);

        if ($handover_id) {
            redirect('serah-terima/success/' . $handover_id);
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan transaksi serah terima!');
            redirect('serah-terima');
        }
    }

    public function success($id) {
        $data['handover'] = $this->Handover_model->get_by_id($id);
        if (!$data['handover']) {
            show_404();
        }
        $data['title'] = 'Serah Terima Berhasil';
        $this->load->view('layouts/public_header', $data);
        $this->load->view('handovers/success', $data);
        $this->load->view('layouts/public_footer', $data);
    }

    private function _save_base64_image($base64_string, $folder, $prefix) {
        if (empty($base64_string) || strpos($base64_string, 'data:image') === false) {
            return null;
        }

        $upload_dir = FCPATH . 'uploads/' . $folder . '/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }

        $parts = explode(',', $base64_string);
        if (count($parts) < 2) {
            return null;
        }

        $decoded_image = base64_decode($parts[1]);
        if (!$decoded_image) {
            return null;
        }

        $filename = $prefix . '_' . time() . '_' . substr(md5(mt_rand()), 0, 8) . '.png';
        $full_path = $upload_dir . $filename;

        if (file_put_contents($full_path, $decoded_image)) {
            return 'uploads/' . $folder . '/' . $filename;
        }

        return null;
    }
}
