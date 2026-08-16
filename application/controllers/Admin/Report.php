<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Handover_model');
    }

    public function issues() {
        $data['title'] = 'Laporan Barang Bermasalah (Rusak / Perlu Perbaikan / Selisih)';
        $data['problem_items'] = $this->Handover_model->get_problem_items_summary(50);

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/reports/issues', $data);
        $this->load->view('layouts/admin_footer', $data);
    }
}
