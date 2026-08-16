<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_item_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all($active_only = false) {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('name', 'ASC');
        return $this->db->get('inventory_items')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('inventory_items', array('id' => $id))->row_array();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('inventory_items', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('inventory_items', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('inventory_items');
    }
}
