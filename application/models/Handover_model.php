<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handover_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function generate_handover_number() {
        $today = date('Ymd');
        $prefix = 'STR-' . $today . '-';
        
        $this->db->select('handover_number');
        $this->db->like('handover_number', $prefix, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get('handovers')->row_array();

        if ($last) {
            $last_num = (int) substr($last['handover_number'], -5);
            $new_num = $last_num + 1;
        } else {
            $new_num = 1;
        }

        return $prefix . str_pad($new_num, 5, '0', STR_PAD_LEFT);
    }

    public function get_all($filters = array(), $limit = 20, $offset = 0) {
        $this->db->select('handovers.*, rooms.name as room_name, room_numbers.display_name as room_number_name, users.name as reviewer_name');
        $this->db->from('handovers');
        $this->db->join('rooms', 'rooms.id = handovers.room_id', 'left');
        $this->db->join('room_numbers', 'room_numbers.id = handovers.room_number_id', 'left');
        $this->db->join('users', 'users.id = handovers.reviewed_by', 'left');

        if (!empty($filters['status'])) {
            $this->db->where('handovers.status', $filters['status']);
        }
        if (!empty($filters['room_id'])) {
            $this->db->where('handovers.room_id', $filters['room_id']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('handovers.handover_date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('handovers.handover_date <=', $filters['date_to']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('handovers.handover_number', $filters['search']);
            $this->db->or_like('handovers.sender_name', $filters['search']);
            $this->db->or_like('handovers.receiver_name', $filters['search']);
            $this->db->group_end();
        }

        $this->db->order_by('handovers.created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    public function count_all($filters = array()) {
        $this->db->from('handovers');
        if (!empty($filters['status'])) {
            $this->db->where('handovers.status', $filters['status']);
        }
        if (!empty($filters['room_id'])) {
            $this->db->where('handovers.room_id', $filters['room_id']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('handovers.handover_date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('handovers.handover_date <=', $filters['date_to']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('handovers.handover_number', $filters['search']);
            $this->db->or_like('handovers.sender_name', $filters['search']);
            $this->db->or_like('handovers.receiver_name', $filters['search']);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        $this->db->select('handovers.*, rooms.name as room_name, room_numbers.display_name as room_number_name, users.name as reviewer_name');
        $this->db->from('handovers');
        $this->db->join('rooms', 'rooms.id = handovers.room_id', 'left');
        $this->db->join('room_numbers', 'room_numbers.id = handovers.room_number_id', 'left');
        $this->db->join('users', 'users.id = handovers.reviewed_by', 'left');
        $this->db->where('handovers.id', $id);
        $handover = $this->db->get()->row_array();

        if ($handover) {
            $this->db->select('*');
            $this->db->from('handover_inventory_items');
            $this->db->where('handover_id', $id);
            $this->db->order_by('id', 'ASC');
            $handover['items'] = $this->db->get()->result_array();
        }
        return $handover;
    }

    public function save_handover($data, $items) {
        $this->db->trans_start();

        $data['handover_number'] = $this->generate_handover_number();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert('handovers', $data);
        $handover_id = $this->db->insert_id();

        if (!empty($items)) {
            $now = date('Y-m-d H:i:s');
            foreach ($items as &$item) {
                $item['handover_id'] = $handover_id;
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
            }
            $this->db->insert_batch('handover_inventory_items', $items);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $handover_id;
    }

    public function review($id, $user_id) {
        $data = array(
            'status' => 'reviewed',
            'reviewed_by' => $user_id,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        return $this->db->update('handovers', $data);
    }

    public function delete($id) {
        $this->db->trans_start();
        $this->db->where('handover_id', $id);
        $this->db->delete('handover_inventory_items');

        $this->db->where('id', $id);
        $this->db->delete('handovers');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_stats() {
        $today = date('Y-m-d');
        $this_month = date('Y-m');

        $this->db->where('handover_date', $today);
        $today_count = $this->db->count_all_results('handovers');

        $this->db->like('handover_date', $this_month, 'after');
        $month_count = $this->db->count_all_results('handovers');

        $this->db->where('status', 'submitted');
        $pending_count = $this->db->count_all_results('handovers');

        $this->db->select('COUNT(DISTINCT handover_id) as total');
        $this->db->from('handover_inventory_items');
        $this->db->where_in('condition_status', array('damaged', 'need_repair', 'shortage', 'not_available'));
        $issue_query = $this->db->get()->row_array();
        $issues_count = $issue_query['total'] ?? 0;

        return array(
            'today' => $today_count,
            'month' => $month_count,
            'pending' => $pending_count,
            'issues' => $issues_count
        );
    }

    public function get_problem_items_summary($limit = 10) {
        $this->db->select('inventory_name_snapshot, condition_status, COUNT(*) as count');
        $this->db->from('handover_inventory_items');
        $this->db->where_in('condition_status', array('damaged', 'need_repair', 'shortage', 'not_available'));
        $this->db->group_by(array('inventory_name_snapshot', 'condition_status'));
        $this->db->order_by('count', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }
}
