<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="<?= base_url('admin/room-inventories') ?>" class="btn btn-sm btn-outline-secondary fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Kamar
    </a>
    <span class="badge bg-primary fs-6 p-2">
        Ruangan: <?= html_escape($room_number['room_name']) ?> — <?= html_escape($room_number['display_name']) ?>
    </span>
</div>

<form action="<?= base_url('admin/room-inventories/save/' . $room_number['id']) ?>" method="POST">
    <div class="card border mb-4 shadow-sm">
        <div class="card-header bg-light py-3">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-box-seam-fill text-primary me-2"></i> Tentukan Kuantitas Standar Barang untuk Kamar Ini</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="min-width: 250px;">Nama Barang</th>
                        <th style="width: 140px;">Satuan</th>
                        <th style="width: 180px;" class="text-center">Kuantitas Standar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_items as $item): ?>
                        <?php $current_qty = isset($existing_qty[$item['id']]) ? $existing_qty[$item['id']] : 0; ?>
                        <tr>
                            <td class="fw-semibold text-dark"><?= html_escape($item['name']) ?></td>
                            <td><span class="badge bg-light text-dark border"><?= html_escape($item['unit']) ?></span></td>
                            <td>
                                <input type="number" name="items[<?= $item['id'] ?>]" class="form-control form-control-sm text-center fw-bold" value="<?= $current_qty ?>" min="0" max="99">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white py-3 text-end">
            <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                <i class="bi bi-floppy-fill me-1"></i> Simpan Standar Inventaris Kamar
            </button>
        </div>
    </div>
</form>
