<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Room_number_model');
        $this->load->model('Room_inventory_model');
    }

    public function get_room_numbers($room_id) {
        $room_numbers = $this->Room_number_model->get_by_room_id($room_id, true);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array(
                 'status' => 'success',
                 'data' => $room_numbers
             )));
    }

    public function get_room_inventories($room_number_id) {
        $inventories = $this->Room_inventory_model->get_by_room_number($room_number_id);
        
        // Group by a single dummy category for seamless JS rendering
        $categories = array(
            array(
                'category_name' => 'Fasilitas & Inventaris',
                'items' => $inventories
            )
        );

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array(
                 'status' => 'success',
                 'data' => $categories
             )));
    }
}
