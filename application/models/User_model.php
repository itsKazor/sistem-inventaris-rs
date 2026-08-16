<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
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
}
