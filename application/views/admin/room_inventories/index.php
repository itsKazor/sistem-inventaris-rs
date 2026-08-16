<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-sliders text-primary me-2"></i>Pengaturan Standar Inventaris Kamar</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Atur jumlah standar barang inventaris untuk setiap kamar.</p>
    </div>
</div>

<div class="card border mb-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ruangan</th>
                    <th>Nama Kamar</th>
                    <th class="text-end">Aksi Setup</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($room_numbers)): ?>
                    <?php foreach ($room_numbers as $rn): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= html_escape($rn['room_name']) ?></td>
                            <td class="fw-semibold"><?= html_escape($rn['display_name']) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/room-inventories/' . $rn['id']) ?>" class="btn btn-sm btn-primary fw-semibold shadow-sm">
                                    <i class="bi bi-sliders me-1"></i> Atur Barang Standar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada kamar terdaftar.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
