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
        $data['title'] = 'Pengaturan Profil Admin';

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/profile/index', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function update() {
        if ($this->input->method() !== 'post') {
            redirect('admin/profile');
        }

        $admin_id = $this->session->userdata('admin_id');
        $user = $this->User_model->get_by_id($admin_id);

        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan!');
            redirect('admin/profile');
        }

        $name = trim($this->input->post('name'));
        $username = trim($this->input->post('username'));
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        if (empty($name)) {
            $this->session->set_flashdata('error', 'Nama lengkap wajib diisi!');
            redirect('admin/profile');
        }

        if (empty($username)) {
            $this->session->set_flashdata('error', 'Username wajib diisi!');
            redirect('admin/profile');
        }

        // Check username uniqueness
        if ($this->User_model->check_username_exists($username, $admin_id)) {
            $this->session->set_flashdata('error', 'Username "' . html_escape($username) . '" sudah digunakan oleh akun lain!');
            redirect('admin/profile');
        }

        $update_data = array(
            'name' => $name,
            'username' => $username
        );

        // Password change logic
        if (!empty($new_password) || !empty($current_password)) {
            if (empty($current_password)) {
                $this->session->set_flashdata('error', 'Harap masukkan Password Saat Ini untuk mengonfirmasi perubahan password!');
                redirect('admin/profile');
            }

            if (!password_verify($current_password, $user['password'])) {
                $this->session->set_flashdata('error', 'Password saat ini tidak cocok / salah!');
                redirect('admin/profile');
            }

            if (empty($new_password) || strlen($new_password) < 6) {
                $this->session->set_flashdata('error', 'Password baru minimal 6 karakter!');
                redirect('admin/profile');
            }

            if ($new_password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Konfirmasi password baru tidak cocok!');
                redirect('admin/profile');
            }

            $update_data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $this->User_model->update($admin_id, $update_data);

        // Update active session data
        $this->session->set_userdata('admin_name', $name);
        $this->session->set_userdata('admin_username', $username);

        $this->session->set_flashdata('success', 'Profil dan kata sandi akun berhasil diperbarui!');
        redirect('admin/profile');
    }
}
