<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <a href="<?= base_url('admin/handovers/show/' . $handover['id']) ?>" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Transaksi
        </a>
        <h4 class="fw-bold mb-1"><i class="bi bi-box-arrow-right text-danger me-2"></i>Check-out</h4>
        <p class="text-muted mb-0">Pemeriksaan fisik inventaris kamar saat pasien akan pulang.</p>
    </div>
    <div class="text-end">
        <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">
            No. Dokumen Awal: <strong class="text-primary font-monospace"><?= html_escape($handover['handover_number']) ?></strong>
        </span>
    </div>
</div>

<!-- INFORMASI KAMAR & PASIEN MASUK (BASELINE) -->
<div class="card border mb-4 shadow-sm">
    <div class="card-header bg-light py-2">
        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle text-primary me-2"></i>Data Awal Pasien Masuk (Check-in)</h6>
    </div>
    <div class="card-body py-3">
        <div class="row g-3" style="font-size: .9rem;">
            <div class="col-md-3 col-sm-6">
                <small class="text-muted d-block">Ruangan &amp; Kamar</small>
                <strong class="text-dark fs-6"><?= html_escape($handover['room_name']) ?> (<?= html_escape($handover['room_number_name']) ?>)</strong>
            </div>
            <div class="col-md-3 col-sm-6">
                <small class="text-muted d-block">Tanggal Masuk (Check-in)</small>
                <strong class="text-dark"><?= date('d F Y', strtotime($handover['handover_date'])) ?> <?= html_escape($handover['handover_time']) ?> WIB</strong>
            </div>
            <div class="col-md-3 col-sm-6">
                <small class="text-muted d-block">Nama Penyerah</small>
                <span class="text-dark fw-semibold"><?= html_escape($handover['sender_name']) ?></span>
            </div>
            <div class="col-md-3 col-sm-6">
                <small class="text-muted d-block">Nama Penerima </small>
                <span class="text-dark fw-semibold"><?= html_escape($handover['receiver_name']) ?></span>
            </div>
        </div>
    </div>
</div>

<form action="<?= base_url('admin/handovers/save-checkout/' . $handover['id']) ?>" method="POST" id="checkoutForm">

    <!-- 1. DATA KEPULANGAN -->
    <div class="card border mb-4 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar-check text-primary me-2"></i>1. Identitas Pemeriksa</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Check-out <span class="text-danger">*</span></label>
                    <input type="date" name="checkout_date" class="form-control form-control-sm" value="<?= html_escape($currentDate) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Waktu Check-out <span class="text-danger">*</span></label>
                    <input type="text" name="checkout_time" class="form-control form-control-sm" value="<?= html_escape($currentTime) ?>" pattern="[0-9]{2}:[0-9]{2}" placeholder="HH:MM (contoh: 14:30)" maxlength="5" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Pemeriksa <span class="text-danger">*</span></label>
                    <input type="text" name="checkout_officer_name" class="form-control form-control-sm" value="<?= html_escape($handover['checkout_officer_name'] ?: ($this->session->userdata('admin_name') ?: 'Petugas Ruangan')) ?>" placeholder="Nama Perawat/Petugas" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Nama Penerima <span class="text-danger">*</span></label>
                    <input type="text" name="checkout_patient_rep" class="form-control form-control-sm" value="<?= html_escape($handover['checkout_patient_rep'] ?: $handover['receiver_name']) ?>" placeholder="Nama Pasien / Penanggung Jawab" required>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TABEL REKONSILIASI INVENTARIS -->
    <div class="card border mb-4 shadow-sm">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-clipboard2-check text-primary me-2"></i>2. Pemeriksaan Fisik Inventaris</h6>
                <small class="text-muted">Periksa kembali kondisi inventaris kamar saat ini.</small>
            </div>
            <div class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Centang "Wajib Ganti" jika barang hilang atau dirusak pasien
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" style="font-size: .88rem; width: 100%;">
                    <thead>
                        <tr class="table-light">
                            <th width="40" class="text-center" rowspan="2">No</th>
                            <th style="min-width: 150px;" rowspan="2">Nama Fasilitas</th>
                            <th colspan="2" class="text-center bg-primary-subtle text-primary border-bottom-0">Kondisi Awal (Saat masuk)</th>
                            <th colspan="4" class="text-center bg-warning-subtle text-dark border-bottom-0">Pemeriksaan Aktual</th>
                        </tr>
                        <tr class="table-light">
                            <th width="80" class="text-center bg-primary-subtle text-primary">Qty Awal</th>
                            <th width="90" class="text-center bg-primary-subtle text-primary">Kondisi Awal</th>
                            <th width="95" class="text-center bg-w Marning-subtle">Qty Akhir</th>
                            <th width="90" class="text-center bg-warning-subtle">Selisih</th>
                            <th style="min-width: 250px;" class="text-center bg-warning-subtle">Kondisi Akhir</th>
                            <th style="min-width: 200px;" class="bg-warning-subtle">Catatan / Evaluasi Masalah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $condLabels = array(
                            'good'          => 'Baik',
                            'damaged'       => 'Rusak',
                            'need_repair'   => 'Perbaikan',
                            'shortage'      => 'Kurang',
                            'not_available' => 'Tidak Ada'
                        );
                        ?>
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $idx => $it): ?>
                                <?php
                                $chkQty = isset($it['checkout_actual_qty']) && $it['checkout_actual_qty'] !== null ? $it['checkout_actual_qty'] : $it['actual_quantity'];
                                $chkCond = isset($it['checkout_condition']) && $it['checkout_condition'] !== null ? $it['checkout_condition'] : 'good';
                                $chkNotes = isset($it['checkout_notes']) ? $it['checkout_notes'] : '';
                                $chkLiab = isset($it['is_liability']) ? (int)$it['is_liability'] : 0;
                                $diff = $chkQty - $it['actual_quantity'];
                                ?>
                                <tr id="row_<?= $it['id'] ?>" class="<?= ($diff < 0 || in_array($chkCond, array('damaged', 'shortage', 'not_available'))) ? 'table-danger-subtle' : '' ?>">
                                    <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                    <td>
                                        <span class="fw-bold text-dark d-block"><?= html_escape($it['inventory_name_snapshot']) ?></span>
                                        <small class="text-muted">Standar: <?= $it['standard_quantity_snapshot'] ?> <?= html_escape($it['inventory_unit_snapshot']) ?></small>
                                    </td>
                                    
                                    <!-- BASELINE MASUK -->
                                    <td class="text-center font-monospace bg-light fw-bold">
                                        <?= $it['actual_quantity'] ?> <?= html_escape($it['inventory_unit_snapshot']) ?>
                                    </td>
                                    <td class="text-center bg-light">
                                        <span class="badge bg-secondary"><?= isset($condLabels[$it['condition_status']]) ? $condLabels[$it['condition_status']] : $it['condition_status'] ?></span>
                                    </td>

                                    <!-- INPUT SAAT PULANG -->
                                    <td class="text-center p-1">
                                        <input type="number" min="0" class="form-control form-control-sm text-center fw-bold checkout-qty-input" 
                                            name="checkout_actual_quantity[<?= $it['id'] ?>]" 
                                            id="chk_qty_<?= $it['id'] ?>"
                                            data-init-qty="<?= $it['actual_quantity'] ?>" 
                                            data-item-id="<?= $it['id'] ?>" 
                                            value="<?= $chkQty ?>" required style="min-height:36px;">
                                    </td>
                                    <td class="text-center" id="chk_diff_badge_<?= $it['id'] ?>">
                                        <?php if ($diff === 0): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Pas (0)</span>
                                        <?php elseif ($diff < 0): ?>
                                            <span class="badge bg-danger">Kurang <?= abs($diff) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark">Lebih +<?= $diff ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-1">
                                        <div class="d-flex flex-wrap gap-1">
                                            <input type="radio" class="btn-check chk-cond-radio" name="checkout_condition[<?= $it['id'] ?>]" id="chk_cond_good_<?= $it['id'] ?>" value="good" data-item-id="<?= $it['id'] ?>" <?= $chkCond === 'good' ? 'checked' : '' ?> required>
                                            <label class="btn btn-outline-success btn-sm flex-fill" for="chk_cond_good_<?= $it['id'] ?>">Baik</label>

                                            <input type="radio" class="btn-check chk-cond-radio" name="checkout_condition[<?= $it['id'] ?>]" id="chk_cond_dmg_<?= $it['id'] ?>" value="damaged" data-item-id="<?= $it['id'] ?>" <?= $chkCond === 'damaged' ? 'checked' : '' ?>>
                                            <label class="btn btn-outline-danger btn-sm flex-fill" for="chk_cond_dmg_<?= $it['id'] ?>">Rusak</label>

                                            <input type="radio" class="btn-check chk-cond-radio" name="checkout_condition[<?= $it['id'] ?>]" id="chk_cond_rep_<?= $it['id'] ?>" value="need_repair" data-item-id="<?= $it['id'] ?>" <?= $chkCond === 'need_repair' ? 'checked' : '' ?>>
                                            <label class="btn btn-outline-warning btn-sm flex-fill" for="chk_cond_rep_<?= $it['id'] ?>">Perbaikan</label>

                                            <input type="radio" class="btn-check chk-cond-radio" name="checkout_condition[<?= $it['id'] ?>]" id="chk_cond_sht_<?= $it['id'] ?>" value="shortage" data-item-id="<?= $it['id'] ?>" <?= $chkCond === 'shortage' ? 'checked' : '' ?>>
                                            <label class="btn btn-outline-secondary btn-sm flex-fill" for="chk_cond_sht_<?= $it['id'] ?>">Kurang/Hilang</label>
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <input type="text" class="form-control form-control-sm mb-1 chk-note-input" name="checkout_notes_item[<?= $it['id'] ?>]" id="chk_note_<?= $it['id'] ?>" value="<?= html_escape($chkNotes) ?>" placeholder="Keterangan jika rusak/kurang...">
                                        <div class="form-check form-switch small">
                                            <input class="form-check-input chk-liab-switch" type="checkbox" name="is_liability[<?= $it['id'] ?>]" id="chk_liab_<?= $it['id'] ?>" value="1" <?= $chkLiab === 1 || $diff < 0 || in_array($chkCond, array('damaged', 'shortage', 'not_available')) ? 'checked' : '' ?>>
                                            <label class="form-check-label fw-bold text-danger" for="chk_liab_<?= $it['id'] ?>" style="font-size: .78rem;">
                                                <i class="bi bi-cash-stack me-1"></i> Wajib Ganti Rugi
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. CATATAN & TANDA TANGAN KEPULANGAN -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-journal-text text-primary me-2"></i>3. Catatan Kepulangan / Billing</h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control" name="checkout_notes" rows="4" placeholder="Contoh: Remote AC hilang, pasien bersedia mengganti Rp 250.000"><?= html_escape($handover['checkout_notes']) ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pen-fill text-primary me-2"></i>4. Tanda Tangan Kepala Ruangan</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2 justify-content-center">
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center bg-light">
                                <small class="fw-bold d-block mb-1">Kepala Ruangan</small>
                                <div class="text-muted small mb-2">(Mengetahui)</div>
                                <canvas id="sigCanvasHead" class="sig-canvas bg-white border rounded" style="width: 100%; height: 120px;"></canvas>
                                <input type="hidden" name="signature_data_head" id="sig_data_head">
                                <button type="button" class="btn btn-outline-secondary btn-sm py-0 mt-1 clear-sig-btn" data-target="head" style="font-size: .72rem;">
                                    <i class="bi bi-eraser"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-2" style="font-size: .75rem;">
                        <i class="bi bi-info-circle me-1"></i> Tulis tanda tangan langsung pada kotak di atas.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="card border shadow-sm p-3 bg-light">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <a href="<?= base_url('admin/handovers/show/' . $handover['id']) ?>" class="btn btn-outline-secondary px-4 fw-semibold">
                <i class="bi bi-x-circle me-1"></i> Batal
            </a>
            <button type="submit" id="submitCheckoutBtn" class="btn btn-danger btn-lg px-5 fw-bold shadow">
                <i class="bi bi-check-circle-fill me-2"></i> Simpan &amp; Selesaikan Check-out
            </button>
        </div>
    </div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic diff calculation and auto liability marking
    document.querySelectorAll('.checkout-qty-input').forEach(inp => {
        inp.addEventListener('input', function() {
            const itemId = this.dataset.itemId;
            const initQty = parseInt(this.dataset.initQty) || 0;
            const chkQty = parseInt(this.value) || 0;
            const diff = chkQty - initQty;
            const diffBadge = document.getElementById('chk_diff_badge_' + itemId);
            const liabSwitch = document.getElementById('chk_liab_' + itemId);
            const row = document.getElementById('row_' + itemId);

            if (diff === 0) {
                diffBadge.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle">Pas (0)</span>';
            } else if (diff < 0) {
                diffBadge.innerHTML = `<span class="badge bg-danger">Kurang ${Math.abs(diff)}</span>`;
                if (liabSwitch) liabSwitch.checked = true;
                if (row) row.classList.add('table-danger-subtle');
            } else {
                diffBadge.innerHTML = `<span class="badge bg-info text-dark">Lebih +${diff}</span>`;
            }
        });
    });

    document.querySelectorAll('.chk-cond-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const liabSwitch = document.getElementById('chk_liab_' + itemId);
            const noteInput = document.getElementById('chk_note_' + itemId);
            const row = document.getElementById('row_' + itemId);

            if (['damaged', 'need_repair', 'shortage'].includes(this.value)) {
                if (liabSwitch) liabSwitch.checked = true;
                if (row) row.classList.add('table-danger-subtle');
                if (noteInput && !noteInput.value) {
                    noteInput.placeholder = 'Wajib diisi! Jelaskan kerusakan / penyebab kurang...';
                }
            } else {
                const qtyInput = document.getElementById('chk_qty_' + itemId);
                const initQty = parseInt(qtyInput.dataset.initQty) || 0;
                const chkQty = parseInt(qtyInput.value) || 0;
                if (chkQty >= initQty) {
                    if (liabSwitch) liabSwitch.checked = false;
                    if (row) row.classList.remove('table-danger-subtle');
                }
            }
        });
    });

    // Signature pads
    const sigPads = {};
    ['head'].forEach(type => {
        const canvas = document.getElementById('sigCanvas' + type.charAt(0).toUpperCase() + type.slice(1));
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const hiddenInput = document.getElementById('sig_data_' + type);
        let isDrawing = false;

        function resize() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            ctx.scale(ratio, ratio);
            ctx.strokeStyle = '#dc2626';
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
        }

        resize();
        window.addEventListener('resize', resize);

        function getPos(e) {
            const r = canvas.getBoundingClientRect();
            return { x: e.clientX - r.left, y: e.clientY - r.top };
        }

        canvas.addEventListener('pointerdown', e => {
            isDrawing = true; const p = getPos(e); ctx.beginPath(); ctx.moveTo(p.x, p.y);
        });
        canvas.addEventListener('pointermove', e => {
            if (!isDrawing) return; const p = getPos(e); ctx.lineTo(p.x, p.y); ctx.stroke();
        });
        canvas.addEventListener('pointerup', () => {
            if (isDrawing) { isDrawing = false; ctx.closePath(); hiddenInput.value = canvas.toDataURL('image/png'); }
        });
        canvas.addEventListener('pointerleave', () => {
            if (isDrawing) { isDrawing = false; ctx.closePath(); hiddenInput.value = canvas.toDataURL('image/png'); }
        });

        sigPads[type] = { canvas, ctx, hiddenInput, clear: () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height); hiddenInput.value = '';
        }};
    });

    document.querySelectorAll('.clear-sig-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (sigPads[btn.dataset.target]) {
                sigPads[btn.dataset.target].clear();
            }
        });
    });
});
</script>
