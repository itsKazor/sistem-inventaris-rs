<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends AdminOnly_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $data['title'] = 'Pengaturan User';
        $data['users'] = $this->User_model->get_all();

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('layouts/admin_footer', $data);
    }

    public function store() {
        if ($this->input->method() !== 'post') {
            redirect('admin/users');
        }

        $username = trim($this->input->post('username'));
        $name     = trim($this->input->post('name'));
        $password = trim($this->input->post('password'));
        $role     = $this->input->post('role');
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (empty($username) || empty($name) || empty($password)) {
            $this->session->set_flashdata('error', 'Username, nama, dan password wajib diisi!');
            redirect('admin/users');
        }

        if (strlen($password) < 6) {
            $this->session->set_flashdata('error', 'Password minimal 6 karakter!');
            redirect('admin/users');
        }

        if (!in_array($role, array('administrator', 'kepala_ruangan'))) {
            $this->session->set_flashdata('error', 'Role tidak valid!');
            redirect('admin/users');
        }

        if ($this->User_model->check_username_exists($username)) {
            $this->session->set_flashdata('error', 'Username sudah digunakan!');
            redirect('admin/users');
        }

        $this->User_model->insert(array(
            'username'  => $username,
            'name'      => $name,
            'email'     => $username . '@rs.local',
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'role'      => $role,
            'is_active' => $is_active
        ));

        $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        redirect('admin/users');
    }

    public function update($id) {
        if ($this->input->method() !== 'post') {
            redirect('admin/users');
        }

        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        $username  = trim($this->input->post('username'));
        $name      = trim($this->input->post('name'));
        $role      = $this->input->post('role');
        $is_active = $this->input->post('is_active') ? 1 : 0;

        if (empty($username) || empty($name)) {
            $this->session->set_flashdata('error', 'Username dan nama wajib diisi!');
            redirect('admin/users');
        }

        if (!in_array($role, array('administrator', 'kepala_ruangan'))) {
            $this->session->set_flashdata('error', 'Role tidak valid!');
            redirect('admin/users');
        }

        if ($this->User_model->check_username_exists($username, $id)) {
            $this->session->set_flashdata('error', 'Username sudah digunakan oleh user lain!');
            redirect('admin/users');
        }

        // Jangan izinkan administrator mengedit dirinya sendiri menjadi kepala_ruangan
        $current_admin_id = $this->session->userdata('admin_id');
        if ((int)$id === (int)$current_admin_id && $role !== 'administrator') {
            $this->session->set_flashdata('error', 'Anda tidak dapat mengubah role akun Anda sendiri!');
            redirect('admin/users');
        }

        $update_data = array(
            'username'  => $username,
            'name'      => $name,
            'role'      => $role,
            'is_active' => $is_active
        );

        $this->User_model->update($id, $update_data);

        // Update session jika user yang diedit adalah user yang sedang login
        if ((int)$id === (int)$current_admin_id) {
            $this->session->set_userdata('admin_username', $username);
            $this->session->set_userdata('admin_name', $name);
        }

        $this->session->set_flashdata('success', 'Data user berhasil diperbarui!');
        redirect('admin/users');
    }

    public function reset_password($id) {
        if ($this->input->method() !== 'post') {
            redirect('admin/users');
        }

        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        $new_password = trim($this->input->post('new_password'));
        if (empty($new_password) || strlen($new_password) < 6) {
            $this->session->set_flashdata('error', 'Password baru minimal 6 karakter!');
            redirect('admin/users');
        }

        $this->User_model->update($id, array(
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
        ));

        $this->session->set_flashdata('success', 'Password user berhasil direset!');
        redirect('admin/users');
    }

    public function delete($id) {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        // Jangan izinkan hapus diri sendiri
        $current_admin_id = $this->session->userdata('admin_id');
        if ((int)$id === (int)$current_admin_id) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
            redirect('admin/users');
        }

        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('admin/users');
    }
}
