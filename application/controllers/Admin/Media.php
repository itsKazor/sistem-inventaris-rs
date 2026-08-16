<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Handover_model');
    }

    public function patient_photo($handover_id) {
        $handover = $this->Handover_model->get_by_id($handover_id);
        if (!$handover || empty($handover['patient_photo_path'])) {
            show_404();
        }

        $full_path = FCPATH . ltrim($handover['patient_photo_path'], '/\\');
        if (!file_exists($full_path)) {
            show_404();
        }

        $mime = @mime_content_type($full_path) ?: 'image/png';
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($full_path));
        readfile($full_path);
        exit;
    }

    public function signature($handover_id, $type) {
        $handover = $this->Handover_model->get_by_id($handover_id);
        if (!$handover) {
            show_404();
        }

        $path = '';
        if ($type === 'sender') {
            $path = $handover['sender_signature_path'];
        } elseif ($type === 'receiver') {
            $path = $handover['receiver_signature_path'];
        } elseif ($type === 'acknowledgement' || $type === 'head') {
            $path = $handover['acknowledgement_signature_path'];
        }

        if (empty($path)) {
            show_404();
        }

        $full_path = FCPATH . ltrim($path, '/\\');
        if (!file_exists($full_path)) {
            show_404();
        }

        $mime = @mime_content_type($full_path) ?: 'image/png';
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($full_path));
        readfile($full_path);
        exit;
    }
}
