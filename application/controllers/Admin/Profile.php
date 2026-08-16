<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $admin_id = $this->session->userdata('admin_id');
        $user = $this->User_model->get_by_id($admin_id);

        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan!');
            redirect('admin/dashboard');
        }

        $data['user'] = $user;
        $data['title'] = 'Ganti Password Admin';

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/profile/index', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function update() {
        if ($this->input->method() !== 'post') {
            redirect('admin/change-password');
        }

        $admin_id = $this->session->userdata('admin_id');
        $user = $this->User_model->get_by_id($admin_id);

        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan!');
            redirect('admin/change-password');
        }

        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        if (empty($current_password)) {
            $this->session->set_flashdata('error', 'Password saat ini wajib diisi!');
            redirect('admin/change-password');
        }

        if (!password_verify($current_password, $user['password'])) {
            $this->session->set_flashdata('error', 'Password saat ini salah!');
            redirect('admin/change-password');
        }

        if (empty($new_password) || strlen($new_password) < 6) {
            $this->session->set_flashdata('error', 'Password baru minimal 6 karakter!');
            redirect('admin/change-password');
        }

        if ($new_password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Konfirmasi password baru tidak cocok!');
            redirect('admin/change-password');
        }

        $update_data = array(
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
        );

        $this->User_model->update($admin_id, $update_data);

        $this->session->set_flashdata('success', 'Password akun Anda berhasil diperbarui!');
        redirect('admin/change-password');
    }
}
