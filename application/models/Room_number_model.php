<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_number_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all($room_id = null, $active_only = false) {
        $this->db->select('room_numbers.*, rooms.name as room_name, rooms.code as room_code');
        $this->db->from('room_numbers');
        $this->db->join('rooms', 'rooms.id = room_numbers.room_id');
        if ($room_id) {
            $this->db->where('room_numbers.room_id', $room_id);
        }
        if ($active_only) {
            $this->db->where('room_numbers.is_active', 1);
        }
        $this->db->order_by('rooms.name', 'ASC');
        $this->db->order_by('room_numbers.room_number', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('room_numbers.*, rooms.name as room_name, rooms.code as room_code');
        $this->db->from('room_numbers');
        $this->db->join('rooms', 'rooms.id = room_numbers.room_id');
        $this->db->where('room_numbers.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_by_room_id($room_id, $active_only = true) {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->where('room_id', $room_id);
        $this->db->order_by('display_name', 'ASC');
        return $this->db->get('room_numbers')->result_array();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('room_numbers', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('room_numbers', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('room_numbers');
    }
}
