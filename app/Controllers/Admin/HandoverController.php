<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HandoverInventoryItemModel;
use App\Models\HandoverModel;
use App\Models\HandoverRoomPhotoModel;
use App\Models\RoomModel;
use App\Models\RoomNumberModel;

class HandoverController extends BaseController
{
    protected HandoverModel $handoverModel;
    protected HandoverInventoryItemModel $handoverInventoryItemModel;
    protected HandoverRoomPhotoModel $handoverPhotoModel;
    protected RoomModel $roomModel;
    protected RoomNumberModel $roomNumberModel;

    public function __construct()
    {
        $this->handoverModel              = new HandoverModel();
        $this->handoverInventoryItemModel = new HandoverInventoryItemModel();
        $this->handoverPhotoModel         = new HandoverRoomPhotoModel();
        $this->roomModel                  = new RoomModel();
        $this->roomNumberModel            = new RoomNumberModel();
    }

    public function index()
    {
        $search     = $this->request->getGet('search');
        $startDate  = $this->request->getGet('start_date');
        $endDate    = $this->request->getGet('end_date');
        $roomId     = $this->request->getGet('room_id');
        $roomNumId  = $this->request->getGet('room_number_id');
        $status     = $this->request->getGet('status');

        $builder = $this->handoverModel->select('handovers.*, rooms.name as room_name, room_numbers.display_name as room_number_name, users.name as reviewer_name')
                                       ->join('rooms', 'rooms.id = handovers.room_id')
                                       ->join('room_numbers', 'room_numbers.id = handovers.room_number_id')
                                       ->join('users', 'users.id = handovers.reviewed_by', 'left');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('handover_number', $search)
                    ->orLike('sender_name', $search)
                    ->orLike('receiver_name', $search)
                    ->groupEnd();
        }

        if (!empty($startDate)) {
            $builder->where('handover_date >=', $startDate);
        }

        if (!empty($endDate)) {
            $builder->where('handover_date <=', $endDate);
        }

        if (!empty($roomId)) {
            $builder->where('handovers.room_id', $roomId);
        }

        if (!empty($roomNumId)) {
            $builder->where('handovers.room_number_id', $roomNumId);
        }

        if (!empty($status)) {
            $builder->where('handovers.status', $status);
        }

        $handovers = $builder->orderBy('handovers.id', 'DESC')->paginate(15);
        $pager     = $this->handoverModel->pager;

        // Attach issue count per handover
        foreach ($handovers as &$h) {
            $issues = $this->handoverInventoryItemModel->where('handover_id', $h['id'])
                                                        ->whereIn('condition_status', ['damaged', 'need_repair', 'shortage', 'not_available'])
                                                        ->countAllResults();
            $h['issue_count'] = $issues;
        }

        $rooms       = $this->roomModel->getActiveRooms();
        $roomNumbers = !empty($roomId) ? $this->roomNumberModel->getActiveByRoomId((int)$roomId) : [];

        return view('admin/handovers/index', [
            'title'       => 'Daftar Serah Terima Kamar',
            'handovers'   => $handovers,
            'pager'       => $pager,
            'rooms'       => $rooms,
            'roomNumbers' => $roomNumbers,
            'filters'     => [
                'search'         => $search,
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'room_id'        => $roomId,
                'room_number_id' => $roomNumId,
                'status'         => $status,
            ],
        ]);
    }

    public function show(int $id)
    {
        $handover = $this->handoverModel->getDetailById($id);
        if (!$handover) {
            return redirect()->to(base_url('admin/handovers'))->with('error', 'Data serah terima tidak ditemukan.');
        }

        $items      = $this->handoverInventoryItemModel->getItemsByHandoverId($id);
        $roomPhotos = $this->handoverPhotoModel->getPhotosByHandoverId($id);

        return view('admin/handovers/show', [
            'title'      => 'Detail Serah Terima: ' . $handover['handover_number'],
            'handover'   => $handover,
            'items'      => $items,
            'roomPhotos' => $roomPhotos,
        ]);
    }

    public function review(int $id)
    {
        $handover = $this->handoverModel->find($id);
        if (!$handover) {
            return redirect()->to(base_url('admin/handovers'))->with('error', 'Data serah terima tidak ditemukan.');
        }

        $this->handoverModel->update($id, [
            'status'      => 'reviewed',
            'reviewed_by' => session()->get('user_id'),
            'reviewed_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Transaksi serah terima berhasil ditandai sebagai reviewed.');
    }

    public function history(int $roomNumberId)
    {
        $roomNumber = $this->roomNumberModel->select('room_numbers.*, rooms.name as room_name, rooms.code as room_code')
                                            ->join('rooms', 'rooms.id = room_numbers.room_id')
                                            ->where('room_numbers.id', $roomNumberId)
                                            ->first();

        if (!$roomNumber) {
            return redirect()->to(base_url('admin/handovers'))->with('error', 'Kamar tidak ditemukan.');
        }

        $handovers = $this->handoverModel->select('handovers.*, users.name as reviewer_name')
                                         ->join('users', 'users.id = handovers.reviewed_by', 'left')
                                         ->where('room_number_id', $roomNumberId)
                                         ->orderBy('handover_date', 'DESC')
                                         ->orderBy('handover_time', 'DESC')
                                         ->findAll();

        // Summarize items for each history transaction
        foreach ($handovers as &$h) {
            $items = $this->handoverInventoryItemModel->getItemsByHandoverId($h['id']);
            $summary = [
                'good'         => 0,
                'damaged'      => 0,
                'need_repair'  => 0,
                'shortage'     => 0,
                'not_available'=> 0,
            ];
            foreach ($items as $it) {
                $status = $it['condition_status'];
                if (isset($summary[$status])) {
                    $summary[$status]++;
                }
            }
            $h['summary'] = $summary;
        }

        return view('admin/room_numbers/history', [
            'title'      => 'Riwayat Kondisi: ' . $roomNumber['room_name'] . ' - ' . $roomNumber['display_name'],
            'roomNumber' => $roomNumber,
            'handovers'  => $handovers,
        ]);
    }

    public function delete(int $id)
    {
        $handover = $this->handoverModel->find($id);
        if (!$handover) {
            return redirect()->to(base_url('admin/handovers'))->with('error', 'Data serah terima tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Delete physical uploaded files
            if (!empty($handover['patient_photo_path'])) {
                @unlink(WRITEPATH . 'uploads/' . $handover['patient_photo_path']);
            }
            if (!empty($handover['sender_signature_path'])) {
                @unlink(WRITEPATH . 'uploads/' . $handover['sender_signature_path']);
            }
            if (!empty($handover['receiver_signature_path'])) {
                @unlink(WRITEPATH . 'uploads/' . $handover['receiver_signature_path']);
            }
            if (!empty($handover['acknowledgement_signature_path'])) {
                @unlink(WRITEPATH . 'uploads/' . $handover['acknowledgement_signature_path']);
            }

            // Delete room photos
            $roomPhotos = $this->handoverPhotoModel->getPhotosByHandoverId($id);
            foreach ($roomPhotos as $photo) {
                if (!empty($photo['file_path'])) {
                    @unlink(WRITEPATH . 'uploads/' . $photo['file_path']);
                }
            }

            // Database cascade / deletion
            $this->handoverPhotoModel->where('handover_id', $id)->delete();
            $this->handoverInventoryItemModel->where('handover_id', $id)->delete();
            $this->handoverModel->delete($id);

            $db->transCommit();
            return redirect()->to(base_url('admin/handovers'))->with('success', 'Transaksi serah terima ' . $handover['handover_number'] . ' beserta seluruh file foto dan tanda tangan berhasil dihapus permanen.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to(base_url('admin/handovers'))->with('error', 'Gagal menghapus transaksi serah terima: ' . $e->getMessage());
        }
    }
}
