<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_inventory_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_by_room_number($room_number_id) {
        $this->db->select('room_inventories.*, inventory_items.name as inventory_name, inventory_items.unit as inventory_unit');
        $this->db->from('room_inventories');
        $this->db->join('inventory_items', 'inventory_items.id = room_inventories.inventory_item_id');
        $this->db->where('room_inventories.room_number_id', $room_number_id);
        $this->db->where('inventory_items.is_active', 1);
        $this->db->order_by('inventory_items.sort_order', 'ASC');
        $this->db->order_by('inventory_items.name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function save_room_inventories($room_number_id, $items) {
        $this->db->trans_start();
        $this->db->where('room_number_id', $room_number_id);
        $this->db->delete('room_inventories');

        if (!empty($items)) {
            $insert_batch = array();
            $now = date('Y-m-d H:i:s');
            foreach ($items as $item_id => $qty) {
                if ($qty > 0) {
                    $insert_batch[] = array(
                        'room_number_id' => $room_number_id,
                        'inventory_item_id' => $item_id,
                        'standard_quantity' => (int) $qty,
                        'created_at' => $now,
                        'updated_at' => $now
                    );
                }
            }
            if (!empty($insert_batch)) {
                $this->db->insert_batch('room_inventories', $insert_batch);
            }
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
