<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverInventoryItemModel;
use App\Models\HandoverModel;
use App\Models\HandoverRoomPhotoModel;
use App\Models\RoomInventoryModel;
use App\Models\RoomModel;
use App\Models\RoomNumberModel;

class HandoverController extends BaseController
{
    protected RoomModel $roomModel;
    protected RoomNumberModel $roomNumberModel;
    protected RoomInventoryModel $roomInventoryModel;
    protected HandoverModel $handoverModel;
    protected HandoverInventoryItemModel $handoverInventoryItemModel;
    protected HandoverRoomPhotoModel $handoverPhotoModel;

    public function __construct()
    {
        $this->roomModel                  = new RoomModel();
        $this->roomNumberModel            = new RoomNumberModel();
        $this->roomInventoryModel         = new RoomInventoryModel();
        $this->handoverModel              = new HandoverModel();
        $this->handoverInventoryItemModel = new HandoverInventoryItemModel();
        $this->handoverPhotoModel         = new HandoverRoomPhotoModel();
    }

    public function index()
    {
        $rooms = $this->roomModel->getActiveRooms();

        return view('handovers/form', [
            'title'       => 'Form Serah Terima Kamar Rumah Sakit',
            'rooms'       => $rooms,
            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i'),
        ]);
    }

    public function save()
    {
        // 1. Validation Rules
        $rules = [
            'handover_date'       => 'required|valid_date[Y-m-d]',
            'handover_time'       => 'required',
            'room_id'             => 'required|numeric',
            'room_number_id'      => 'required|numeric',
            'sender_name'         => 'required|min_length[2]|max_length[100]',
            'receiver_name'       => 'required|min_length[2]|max_length[100]',
            'statement'           => 'required',
            'signature_data_sender'   => 'required',
            'signature_data_receiver' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Lengkapi seluruh field wajib (Ruang, Kamar, Petugas Penyerah & Penerima, Tanda Tangan, dan Konfirmasi Pernyataan).');
        }

        $roomNumberId = (int) $this->request->getPost('room_number_id');

        // Fetch standard room inventories for snapshot
        $standards = $this->roomInventoryModel->getStandardsByRoomNumberId($roomNumberId);
        if (empty($standards)) {
            return redirect()->back()->withInput()->with('error', 'Kamar yang dipilih belum memiliki inventaris standar. Harap hubungi Admin.');
        }

        $actualInput    = $this->request->getPost('actual_quantity') ?? [];
        $conditionInput = $this->request->getPost('condition') ?? [];
        $notesInput     = $this->request->getPost('inventory_notes') ?? [];

        // Validate each item condition status & required notes for problematic items
        foreach ($standards as $stdItem) {
            $itemId = $stdItem['inventory_item_id'];
            if (!isset($conditionInput[$itemId])) {
                return redirect()->back()->withInput()->with('error', 'Harap tentukan status kondisi untuk seluruh inventaris kamar.');
            }

            $status = $conditionInput[$itemId];
            $note   = trim($notesInput[$itemId] ?? '');

            if (in_array($status, ['damaged', 'need_repair', 'shortage']) && empty($note)) {
                return redirect()->back()->withInput()->with('error', 'Harap sertakan keterangan/catatan untuk barang dengan kondisi Rusak, Perlu Perbaikan, atau Kurang (' . $stdItem['inventory_name'] . ').');
            }
        }

        // 2. Process Signature Canvas Files
        $signaturePaths = [
            'sender'          => null,
            'receiver'        => null,
            'acknowledgement' => null,
        ];

        foreach (['sender', 'receiver', 'head'] as $sigType) {
            $postKey = ($sigType === 'head') ? 'signature_data_head' : 'signature_data_' . $sigType;
            $sigData = $this->request->getPost($postKey);
            $targetKey = ($sigType === 'head') ? 'acknowledgement' : $sigType;

            if (!empty($sigData) && str_contains($sigData, 'base64,')) {
                $base64Image = explode('base64,', $sigData)[1];
                $decodedImage = base64_decode($base64Image);
                $sigFileName = 'sig_' . $sigType . '_' . time() . '_' . bin2hex(random_bytes(6)) . '.png';
                $fullSigPath = WRITEPATH . 'uploads/signatures/' . $sigFileName;
                
                if (!is_dir(WRITEPATH . 'uploads/signatures/')) {
                    mkdir(WRITEPATH . 'uploads/signatures/', 0777, true);
                }

                file_put_contents($fullSigPath, $decodedImage);
                $signaturePaths[$targetKey] = 'signatures/' . $sigFileName;
            }
        }

        // 3. Process Patient Photo Upload (Optional)
        $patientPhotoPath = null;
        $patientPhoto = $this->request->getFile('patient_photo');
        if ($patientPhoto && $patientPhoto->isValid() && !$patientPhoto->hasMoved()) {
            if (!is_dir(WRITEPATH . 'uploads/handovers/patients/')) {
                mkdir(WRITEPATH . 'uploads/handovers/patients/', 0777, true);
            }
            $patientName = 'patient_' . time() . '_' . $patientPhoto->getRandomName();
            $patientPhoto->move(WRITEPATH . 'uploads/handovers/patients', $patientName);
            $patientPhotoPath = 'handovers/patients/' . $patientName;
        }

        // 4. Process Room Photos Uploads (up to 5 photos)
        $roomPhotosFiles    = $this->request->getFiles()['room_photos'] ?? [];
        $roomPhotosCaptions = $this->request->getPost('room_photos_captions') ?? [];
        $savedRoomPhotos    = [];

        if (!empty($roomPhotosFiles)) {
            $count = 0;
            foreach ($roomPhotosFiles as $idx => $photo) {
                if ($photo->isValid() && !$photo->hasMoved()) {
                    if ($count >= 5) break; // Maximum 5 photos
                    
                    if (!is_dir(WRITEPATH . 'uploads/handovers/rooms/')) {
                        mkdir(WRITEPATH . 'uploads/handovers/rooms/', 0777, true);
                    }

                    $photoName = 'room_' . time() . '_' . $photo->getRandomName();
                    $photo->move(WRITEPATH . 'uploads/handovers/rooms', $photoName);
                    $savedRoomPhotos[] = [
                        'file_path'  => 'handovers/rooms/' . $photoName,
                        'caption'    => $roomPhotosCaptions[$idx] ?? null,
                        'sort_order' => $count + 1,
                    ];
                    $count++;
                }
            }
        }

        // 5. Atomic Database Transaction Execution
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $handoverNumber = $this->handoverModel->generateNumber();

            $handoverData = [
                'handover_number'                 => $handoverNumber,
                'room_id'                         => $this->request->getPost('room_id'),
                'room_number_id'                  => $roomNumberId,
                'handover_date'                   => $this->request->getPost('handover_date'),
                'handover_time'                   => $this->request->getPost('handover_time'),
                'sender_name'                     => $this->request->getPost('sender_name'),
                'sender_position'                 => $this->request->getPost('sender_position'),
                'receiver_name'                   => $this->request->getPost('receiver_name'),
                'receiver_position'               => $this->request->getPost('receiver_position'),
                'notes'                           => $this->request->getPost('notes'),
                'patient_photo_path'              => $patientPhotoPath,
                'sender_signature_path'           => $signaturePaths['sender'],
                'receiver_signature_path'         => $signaturePaths['receiver'],
                'acknowledgement_signature_path'  => $signaturePaths['acknowledgement'],
                'statement_confirmed'             => 1,
                'status'                          => 'submitted',
            ];

            $this->handoverModel->insert($handoverData);
            $handoverId = $this->handoverModel->insertID();

            // Insert Snapshot of Inventories
            foreach ($standards as $stdItem) {
                $itemId   = $stdItem['inventory_item_id'];
                $stdQty   = (int) $stdItem['standard_quantity'];
                $actQty   = isset($actualInput[$itemId]) && $actualInput[$itemId] !== '' ? (int) $actualInput[$itemId] : $stdQty;
                $diffQty  = $actQty - $stdQty;
                $status   = $conditionInput[$itemId];
                $itemNote = $notesInput[$itemId] ?? null;

                $this->handoverInventoryItemModel->insert([
                    'handover_id'                 => $handoverId,
                    'inventory_item_id'          => $itemId,
                    'inventory_name_snapshot'     => $stdItem['inventory_name'],
                    'inventory_unit_snapshot'     => $stdItem['unit'],
                    'standard_quantity_snapshot' => $stdQty,
                    'actual_quantity'            => $actQty,
                    'difference_quantity'        => $diffQty,
                    'condition_status'           => $status,
                    'notes'                      => $itemNote,
                ]);
            }

            // Insert Room Photos
            if (!empty($savedRoomPhotos)) {
                foreach ($savedRoomPhotos as $pData) {
                    $pData['handover_id'] = $handoverId;
                    $this->handoverPhotoModel->insert($pData);
                }
            }

            $db->transCommit();
            return redirect()->to(base_url('serah-terima/success/' . $handoverId));

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan serah terima: ' . $e->getMessage());
        }
    }

    public function success(int $id)
    {
        $handover = $this->handoverModel->getDetailById($id);
        if (!$handover) {
            return redirect()->to(base_url('serah-terima'))->with('error', 'Data tidak ditemukan.');
        }

        $items = $this->handoverInventoryItemModel->getItemsByHandoverId($id);

        $summary = [
            'total'       => count($items),
            'good'        => 0,
            'damaged'     => 0,
            'need_repair' => 0,
            'shortage'    => 0,
        ];

        foreach ($items as $it) {
            $st = $it['condition_status'];
            if ($st === 'good') $summary['good']++;
            elseif ($st === 'damaged') $summary['damaged']++;
            elseif ($st === 'need_repair') $summary['need_repair']++;
            elseif (in_array($st, ['shortage', 'not_available'])) $summary['shortage']++;
        }

        return view('handovers/success', [
            'title'    => 'Serah Terima Berhasil Disimpan',
            'handover' => $handover,
            'summary'  => $summary,
        ]);
    }
}
