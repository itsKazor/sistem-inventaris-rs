<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
}

// Bisa diakses semua role yang sudah login
class Admin_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }
}

// Hanya bisa diakses oleh role administrator
class AdminOnly_Controller extends Admin_Controller {
    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('admin_role') !== 'administrator') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            redirect('admin/dashboard');
        }
    }
}
