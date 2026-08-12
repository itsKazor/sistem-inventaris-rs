<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\HandoverRoomPhotoModel;

class MediaController extends BaseController
{
    public function patientPhoto(int $handoverId)
    {
        $handoverModel = new HandoverModel();
        $handover = $handoverModel->find($handoverId);

        if (!$handover || empty($handover['patient_photo_path'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Foto pasien tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/' . $handover['patient_photo_path'];
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan di server.');
        }

        $mime = mime_content_type($filePath);
        return $this->response->setHeader('Content-Type', $mime)
                              ->setBody(file_get_contents($filePath));
    }

    public function roomPhoto(int $photoId)
    {
        $photoModel = new HandoverRoomPhotoModel();
        $photo = $photoModel->find($photoId);

        if (!$photo || empty($photo['file_path'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Foto ruangan tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/' . $photo['file_path'];
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan di server.');
        }

        $mime = mime_content_type($filePath);
        return $this->response->setHeader('Content-Type', $mime)
                              ->setBody(file_get_contents($filePath));
    }

    public function signature(int $handoverId, string $type = 'sender')
    {
        $handoverModel = new HandoverModel();
        $handover = $handoverModel->find($handoverId);

        $fieldMap = [
            'sender'          => 'sender_signature_path',
            'receiver'        => 'receiver_signature_path',
            'acknowledgement' => 'acknowledgement_signature_path',
        ];

        $field = $fieldMap[$type] ?? 'sender_signature_path';

        if (!$handover || empty($handover[$field])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tanda tangan tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/' . $handover[$field];
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan di server.');
        }

        $mime = mime_content_type($filePath);
        return $this->response->setHeader('Content-Type', $mime)
                              ->setBody(file_get_contents($filePath));
    }
}
