<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('users')->result_array();
    }

    public function get_by_username($username) {
        return $this->db->get_where('users', array('username' => $username, 'is_active' => 1))->row_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('users', array('id' => $id))->row_array();
    }

    public function verify_login($username, $password) {
        $user = $this->get_by_username($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function check_username_exists($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('users') > 0;
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('users', $data);
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete($id) {
        return $this->db->delete('users', array('id' => $id));
    }
}
