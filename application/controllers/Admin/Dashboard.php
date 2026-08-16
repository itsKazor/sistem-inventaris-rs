<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Handover_model');
        $this->load->model('Room_model');
        $this->load->model('Room_number_model');
        $this->load->model('Inventory_item_model');
    }

    public function index() {
        $data['title'] = 'Dashboard Admin';
        $data['stats'] = $this->Handover_model->get_stats();
        $data['recent_handovers'] = $this->Handover_model->get_all(array(), 5, 0);
        $data['problem_items'] = $this->Handover_model->get_problem_items_summary(8);

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('layouts/admin_footer', $data);
    }
}
