<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handover extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Handover_model');
        $this->load->model('Room_model');
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
