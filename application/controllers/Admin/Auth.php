<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }

        if ($this->input->method() === 'post') {
            $username = trim($this->input->post('username'));
            $password = trim($this->input->post('password'));

            $user = $this->User_model->verify_login($username, $password);
            if ($user) {
                $session_data = array(
                    'admin_logged_in' => true,
                    'admin_id'        => $user['id'],
                    'admin_username'  => $user['username'],
                    'admin_name'      => $user['name'],
                    'admin_role'      => $user['role']
                );
                $this->session->set_userdata($session_data);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('admin/login');
            }
        }

        $data['title'] = 'Login Admin - Sistem Inventaris RS';
        $this->load->view('admin/auth/login', $data);
    }

    public function logout() {
        $this->session->unset_userdata(array('admin_logged_in', 'admin_id', 'admin_username', 'admin_name', 'admin_role'));
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
