<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handover extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Handover_model');
        $this->load->model('Room_model');
        $this->load->model('User_model');
    }

    public function index() {
        $filters = array(
            'status'    => $this->input->get('status'),
            'room_id'   => $this->input->get('room_id'),
            'date_from' => $this->input->get('date_from'),
            'date_to'   => $this->input->get('date_to'),
            'search'    => $this->input->get('search')
        );

        $limit = 20;
        $page = (int) $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $limit;

        $data['title'] = 'Data Serah Terima Ruangan';
        $data['handovers'] = $this->Handover_model->get_all($filters, $limit, $offset);
        
        // Calculate issue counts for badges
        foreach ($data['handovers'] as &$h) {
            $this->db->where('handover_id', $h['id']);
            $this->db->where_in('condition_status', array('damaged', 'need_repair', 'shortage', 'not_available'));
            $h['issue_count'] = $this->db->count_all_results('handover_inventory_items');
        }

        $data['total_rows'] = $this->Handover_model->count_all($filters);
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_rows'] / $limit);
        $data['filters'] = $filters;
        $data['rooms'] = $this->Room_model->get_all(true);

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/handovers/index', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function show($id) {
        $data['handover'] = $this->Handover_model->get_by_id($id);
        if (!$data['handover']) {
            show_404();
        }

        $data['items'] = isset($data['handover']['items']) ? $data['handover']['items'] : array();
        $data['title'] = 'Detail Serah Terima: ' . $data['handover']['handover_number'];

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/handovers/show', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function preview($id) {
        $data['handover'] = $this->Handover_model->get_by_id($id);
        if (!$data['handover']) {
            show_404();
        }

        $data['items'] = isset($data['handover']['items']) ? $data['handover']['items'] : array();
        $data['title'] = 'Pratinjau Dokumen: ' . $data['handover']['handover_number'];

        $this->load->view('admin/handovers/preview', $data);
    }

    public function checkout($id) {
        $data['handover'] = $this->Handover_model->get_by_id($id);
        if (!$data['handover']) {
            show_404();
        }

        $data['items'] = isset($data['handover']['items']) ? $data['handover']['items'] : array();
        $data['title'] = 'Audit Check-out Pasien: ' . $data['handover']['handover_number'];
        $data['currentDate'] = date('Y-m-d');
        $data['currentTime'] = date('H:i');

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/handovers/checkout', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function save_checkout($id) {
        if ($this->input->method() !== 'post') {
            redirect('admin/handovers/show/' . $id);
        }

        $handover = $this->Handover_model->get_by_id($id);
        if (!$handover) {
            show_404();
        }

        $checkout_date = $this->input->post('checkout_date') ?: date('Y-m-d');
        $checkout_time = $this->input->post('checkout_time') ?: date('H:i');
        $checkout_officer = trim($this->input->post('checkout_officer_name'));
        $checkout_notes = trim($this->input->post('checkout_notes'));

        // Process base64 signatures
        $head_sig = $this->_save_base64_image($this->input->post('signature_data_head'), 'signatures', 'sig_chk_head');

        $checkout_data = array(
            'checkout_date'         => $checkout_date,
            'checkout_time'         => $checkout_time,
            'checkout_officer_name' => $checkout_officer ?: ($this->session->userdata('admin_name') ?: 'Petugas Ruangan'),
            'checkout_notes'        => $checkout_notes,
            'checkout_status'       => 'cleared'
        );

        $user = $this->User_model->get_by_id($this->session->userdata('admin_id'));
        $checkout_data['checkout_head_name'] = isset($user['name']) ? $user['name'] : '';

        if ($head_sig) {
            $checkout_data['checkout_head_signature_path'] = $head_sig;
        }

        $items_post_qty  = $this->input->post('checkout_actual_quantity');
        $items_post_cond = $this->input->post('checkout_condition');
        $items_post_note = $this->input->post('checkout_notes_item');
        $items_post_liab = $this->input->post('is_liability');

        $items_to_save = array();
        $has_liability = false;

        $db_items = isset($handover['items']) ? $handover['items'] : array();
        foreach ($db_items as $db_item) {
            $item_id = $db_item['id'];
            $act_qty = isset($items_post_qty[$item_id]) ? (int)$items_post_qty[$item_id] : (int)$db_item['actual_quantity'];
            $diff_qty = $act_qty - (int)$db_item['actual_quantity'];
            $cond = isset($items_post_cond[$item_id]) ? $items_post_cond[$item_id] : 'good';
            $note = isset($items_post_note[$item_id]) ? trim($items_post_note[$item_id]) : '';
            $liab = (isset($items_post_liab[$item_id]) && $items_post_liab[$item_id] == 1) ? 1 : 0;

            // Auto liability if quantity decreased or condition is damaged / shortage / not_available
            if ($diff_qty < 0 || in_array($cond, array('damaged', 'shortage', 'not_available'))) {
                $liab = 1;
            }

            if ($liab === 1) {
                $has_liability = true;
            }

            $items_to_save[$item_id] = array(
                'checkout_actual_qty'     => $act_qty,
                'checkout_difference_qty' => $diff_qty,
                'checkout_condition'      => $cond,
                'checkout_notes'          => $note,
                'is_liability'            => $liab
            );
        }

        $checkout_data['checkout_status'] = $has_liability ? 'has_liability' : 'cleared';

        if ($this->Handover_model->save_checkout($id, $checkout_data, $items_to_save)) {
            $this->session->set_flashdata('success', 'Audit pemeriksaan check-out pasien berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan audit check-out!');
        }

        redirect('admin/handovers/show/' . $id);
    }

    public function reset_checkout($id) {
        $handover = $this->Handover_model->get_by_id($id);
        if (!$handover) {
            show_404();
        }

        if ($this->Handover_model->reset_checkout($id)) {
            $this->session->set_flashdata('success', 'Data check-out berhasil direset.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mereset data check-out!');
        }

        redirect('admin/handovers/show/' . $id);
    }

    public function preview_checkout($id) {
        $data['handover'] = $this->Handover_model->get_by_id($id);
        if (!$data['handover']) {
            show_404();
        }

        $data['items'] = isset($data['handover']['items']) ? $data['handover']['items'] : array();
        $data['title'] = 'Berita Acara Check-out: ' . $data['handover']['handover_number'];

        $this->load->view('admin/handovers/preview_checkout', $data);
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

    public function review($id) {
        $handover = $this->Handover_model->get_by_id($id);
        if (!$handover) {
            show_404();
        }

        $user_id = $this->session->userdata('admin_id');
        if ($this->Handover_model->review($id, $user_id)) {
            $this->session->set_flashdata('success', 'Status serah terima berhasil diperbarui menjadi Ditinjau.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status!');
        }

        redirect('admin/handovers/show/' . $id);
    }

    public function delete($id) {
        $handover = $this->Handover_model->get_by_id($id);
        if (!$handover) {
            show_404();
        }

        if ($this->Handover_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data serah terima berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data!');
        }

        redirect('admin/handovers');
    }
}
