<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm mx-auto" style="max-width: 1150px;" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-2 align-middle"></i>
        <span><?= session()->getFlashdata('error') ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form id="handoverForm" action="<?= base_url('serah-terima/save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="paper-document">

        <!-- ========== DOCUMENT HEADER ========== -->
        <div class="row align-items-center mb-0">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('assets/images/logo_rs.png') ?>" alt="RSU Catharina 1914" style="height: 65px; width: auto; object-fit: contain;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="doc-header-title shadow-sm">
                    FORM SERAH TERIMA & INVENTARIS KAMAR<br>RSU CATHARINA 1914
                </div>
            </div>
        </div>

        <hr class="my-3">

        <!-- ========== METADATA HEADER ========== -->
        <div class="row g-3 mb-4" style="font-size: 0.92rem;">
            <div class="col-sm-6">
                <div class="d-flex align-items-center mb-2">
                    <label class="fw-bold text-dark me-2 text-nowrap" style="min-width: 140px;">Ruang Perawatan</label>
                    <span class="me-2">:</span>
                    <select class="form-select form-select-sm" id="room_id" name="room_id" required>
                        <option value="">-- Pilih Ruang --</option>
                        <?php foreach ($rooms as $room): ?>
                            <option value="<?= $room['id'] ?>" <?= old('room_id') == $room['id'] ? 'selected' : '' ?>><?= esc($room['name']) ?> (<?= esc($room['code']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <label class="fw-bold text-dark me-2 text-nowrap" style="min-width: 140px;">Nomor Kamar</label>
                    <span class="me-2">:</span>
                    <select class="form-select form-select-sm" id="room_number_id" name="room_number_id" required disabled>
                        <option value="">-- Pilih Ruang Dulu --</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="d-flex align-items-center mb-2">
                    <label class="fw-bold text-dark me-2 text-nowrap" style="min-width: 160px;">Tanggal Serah Terima</label>
                    <span class="me-2">:</span>
                    <input type="date" class="form-control form-control-sm" id="handover_date" name="handover_date" value="<?= old('handover_date', $currentDate) ?>" required>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <label class="fw-bold text-dark me-2 text-nowrap" style="min-width: 160px;">Waktu Serah Terima</label>
                    <span class="me-2">:</span>
                    <input type="time" class="form-control form-control-sm" id="handover_time" name="handover_time" value="<?= old('handover_time', $currentTime) ?>" required>
                </div>
            </div>
        </div>

        <!-- ========== 1. IDENTITAS ========== -->
        <div class="doc-section-title"><i class="bi bi-people-fill me-2"></i>1. IDENTITAS SERAH TERIMA</div>

        <table class="doc-table mb-4">
            <thead>
                <tr>
                    <th width="50%" class="text-center" style="background-color: var(--rs-header-bg); color: #fff;">Pihak yang Menyerahkan</th>
                    <th width="50%" class="text-center" style="background-color: var(--rs-header-bg); color: #fff;">Pihak yang Menerima</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-3">
                        <div class="mb-2">
                            <label class="fw-bold small text-dark me-2">Nama Lengkap Petugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm mt-1" name="sender_name" value="<?= old('sender_name') ?>" placeholder="Nama petugas penyerah" required>
                        </div>
                        <div>
                            <label class="fw-bold small text-muted me-2">Jabatan / Role (Optional)</label>
                            <input type="text" class="form-control form-control-sm mt-1" name="sender_position" value="<?= old('sender_position') ?>" placeholder="Contoh: Perawat Shift Pagi / Katim">
                        </div>
                    </td>
                    <td class="p-3">
                        <div class="mb-2">
                            <label class="fw-bold small text-dark me-2">Nama Lengkap Petugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm mt-1" name="receiver_name" value="<?= old('receiver_name') ?>" placeholder="Nama petugas penerima" required>
                        </div>
                        <div>
                            <label class="fw-bold small text-muted me-2">Jabatan / Role (Optional)</label>
                            <input type="text" class="form-control form-control-sm mt-1" name="receiver_position" value="<?= old('receiver_position') ?>" placeholder="Contoh: Perawat Shift Sore">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- ========== 2. CHECKLIST INVENTARIS STANDAR & KONDISI AKTUAL ========== -->
        <div class="doc-section-title"><i class="bi bi-ui-checks me-2"></i>2. CHECKLIST INVENTARIS KAMAR & KONDISI AKTUAL</div>

        <div id="inventoriesLoading" class="text-center py-4" style="display: none;">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted fw-bold">Memuat daftar inventaris standar kamar...</p>
        </div>

        <div id="noKamarSelectedAlert" class="alert alert-info text-center py-4 my-3">
            <i class="bi bi-arrow-up-circle fs-3 d-block mb-1"></i>
            Silakan pilih <strong>Ruang Perawatan</strong> dan <strong>Nomor Kamar</strong> di atas untuk memuat inventaris standar.
        </div>

        <div id="inventoriesContainer" class="mb-4" style="display: none;">
            <!-- Dynamic Table / Cards rendered via JS -->
        </div>

        <!-- ========== 3. FOTO DOKUMENTASI (PASIEN & RUANGAN) ========== -->
        <div class="doc-section-title"><i class="bi bi-camera-fill me-2"></i>3. FOTO DOKUMENTASI (PASIEN & RUANGAN)</div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="border rounded p-3 bg-light h-100">
                    <label class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">
                        <i class="bi bi-person-bounding-box me-1 text-info"></i> Upload Foto Pasien <span class="badge bg-danger ms-1" style="font-size: 0.65rem;">Rahasia / Admin Only</span>
                    </label>
                    <div class="text-muted small mb-2">Foto pasien opsional untuk verifikasi admin.</div>
                    <input type="file" class="form-control form-control-sm" id="patient_photo" name="patient_photo" accept="image/*" capture="environment">
                    <div id="patient_photo_preview_container" style="display: none;" class="mt-2 text-center">
                        <img id="patient_photo_preview" src="" alt="Preview Foto Pasien" style="max-height: 90px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border rounded p-3 bg-light h-100">
                    <label class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">
                        <i class="bi bi-images me-1 text-primary"></i> Upload Foto Kondisi Ruangan
                    </label>
                    <div class="text-muted small mb-2">Foto bukti kerusakan/ruangan (Maksimal 5 foto).</div>
                    <input type="file" class="form-control form-control-sm" id="room_photos_input" name="room_photos[]" accept="image/*" capture="environment" multiple>
                    <div id="room_photos_preview_list" class="row g-2 mt-2"></div>
                </div>
            </div>
        </div>

        <!-- ========== 4. CATATAN / HAL PENTING ========== -->
        <div class="doc-section-title"><i class="bi bi-journal-text me-2"></i>4. CATATAN / HAL PENTING</div>

        <div class="border rounded p-2 mb-4">
            <textarea class="form-control border-0" name="notes" rows="3" placeholder="Tuliskan catatan khusus, temuan kondisi fasilitas, atau pesan operasional antar-shift..."><?= old('notes') ?></textarea>
        </div>

        <!-- ========== 5. TANDA TANGAN DIGITAL ========== -->
        <div class="doc-section-title"><i class="bi bi-pen-fill me-2"></i>5. TANDA TANGAN DIGITAL</div>

        <div class="row g-3 mb-4">
            <!-- TTD Menyerahkan -->
            <div class="col-md-4">
                <div class="border rounded p-3 bg-white text-center h-100 d-flex flex-column shadow-sm">
                    <div class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Pihak Menyerahkan <span class="text-danger">*</span></div>
                    <div class="text-muted small mb-2">(Petugas Shift Lama)</div>
                    <div class="signature-box flex-grow-1 mb-2" style="min-height: 140px;">
                        <canvas id="sigCanvasSender" class="sig-canvas" style="width:100%; height:140px;"></canvas>
                    </div>
                    <input type="hidden" name="signature_data_sender" id="sig_data_sender">
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2 clear-sig-btn" data-target="sender"><i class="bi bi-eraser me-1"></i> Hapus Signature</button>
                </div>
            </div>

            <!-- TTD Menerima -->
            <div class="col-md-4">
                <div class="border rounded p-3 bg-white text-center h-100 d-flex flex-column shadow-sm">
                    <div class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Pihak Menerima <span class="text-danger">*</span></div>
                    <div class="text-muted small mb-2">(Petugas Shift Baru)</div>
                    <div class="signature-box flex-grow-1 mb-2" style="min-height: 140px;">
                        <canvas id="sigCanvasReceiver" class="sig-canvas" style="width:100%; height:140px;"></canvas>
                    </div>
                    <input type="hidden" name="signature_data_receiver" id="sig_data_receiver">
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2 clear-sig-btn" data-target="receiver"><i class="bi bi-eraser me-1"></i> Hapus Signature</button>
                </div>
            </div>

            <!-- TTD Mengetahui (Optional) -->
            <div class="col-md-4">
                <div class="border rounded p-3 bg-white text-center h-100 d-flex flex-column shadow-sm">
                    <div class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Mengetahui <span class="text-muted fw-normal">(Optional)</span></div>
                    <div class="text-muted small mb-2">(Kepala Ruangan / Supervisor)</div>
                    <div class="signature-box flex-grow-1 mb-2" style="min-height: 140px;">
                        <canvas id="sigCanvasHead" class="sig-canvas" style="width:100%; height:140px;"></canvas>
                    </div>
                    <input type="hidden" name="signature_data_head" id="sig_data_head">
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2 clear-sig-btn" data-target="head"><i class="bi bi-eraser me-1"></i> Hapus Signature</button>
                </div>
            </div>
        </div>

        <!-- PERNYATAAN & KONFIRMASI -->
        <div class="alert-warning-hospital mb-4 text-center">
            <i class="bi bi-shield-check fs-4 me-2 align-middle"></i>
            Saya menyatakan bahwa kondisi dan inventaris kamar telah diperiksa sesuai dengan kondisi aktual pada saat serah terima.
        </div>

        <div class="form-check p-3 bg-light rounded border mb-4">
            <input class="form-check-input ms-0 me-3" type="checkbox" name="statement" id="statementCheck" value="1" style="width: 1.5em; height: 1.5em;" required>
            <label class="form-check-label fw-bold text-dark" for="statementCheck" style="font-size: 0.92rem;">
                Saya mengonfirmasi bahwa seluruh data serah terima inventaris telah sesuai dan siap disimpan ke sistem.
            </label>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="row g-2 mb-3">
            <div class="col-4">
                <button type="reset" id="resetBtn" class="btn btn-light border text-secondary w-100 py-3 fw-bold">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> RESET FORM
                </button>
            </div>
            <div class="col-8">
                <button type="submit" id="submitBtn" class="btn btn-primary w-100 py-3 fw-bold fs-5 shadow">
                    <i class="bi bi-send-check me-2"></i> KIRIM SERAH TERIMA
                </button>
            </div>
        </div>

    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .status-btn-group .btn {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 6px;
    }
    .status-btn-group .btn-check:checked + .btn-outline-success {
        background-color: #16a34a !important; color: #fff !important;
    }
    .status-btn-group .btn-check:checked + .btn-outline-danger {
        background-color: #dc2626 !important; color: #fff !important;
    }
    .status-btn-group .btn-check:checked + .btn-outline-warning {
        background-color: #d97706 !important; color: #fff !important;
    }
    .status-btn-group .btn-check:checked + .btn-outline-secondary {
        background-color: #475569 !important; color: #fff !important;
    }
    .status-btn-group .btn-check:checked + .btn-outline-dark {
        background-color: #1e293b !important; color: #fff !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== 1. Dynamic Room Numbers Fetch =====
    const roomSelect = document.getElementById('room_id');
    const roomNumberSelect = document.getElementById('room_number_id');
    const noKamarAlert = document.getElementById('noKamarSelectedAlert');
    const inventoriesLoading = document.getElementById('inventoriesLoading');
    const inventoriesContainer = document.getElementById('inventoriesContainer');

    function loadRoomNumbers(roomId, selectedNumId) {
        if (!roomId) {
            roomNumberSelect.innerHTML = '<option value="">-- Pilih Ruang Dulu --</option>';
            roomNumberSelect.disabled = true;
            inventoriesContainer.style.display = 'none';
            noKamarAlert.style.display = 'block';
            return;
        }
        roomNumberSelect.disabled = true;
        roomNumberSelect.innerHTML = '<option value="">Memuat kamar...</option>';

        fetch(`<?= base_url('api/rooms') ?>/${roomId}/rooms`)
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success' && res.data.length > 0) {
                    let opts = '<option value="">-- Pilih Kamar --</option>';
                    res.data.forEach(d => {
                        opts += `<option value="${d.id}" ${selectedNumId == d.id ? 'selected' : ''}>${d.display_name}</option>`;
                    });
                    roomNumberSelect.innerHTML = opts;
                    roomNumberSelect.disabled = false;
                } else {
                    roomNumberSelect.innerHTML = '<option value="">Tidak ada kamar aktif</option>';
                }
            });
    }

    // ===== 2. Dynamic Room Inventories Baseline Fetch =====
    function loadRoomInventories(roomNumberId) {
        if (!roomNumberId) {
            inventoriesContainer.style.display = 'none';
            noKamarAlert.style.display = 'block';
            return;
        }

        noKamarAlert.style.display = 'none';
        inventoriesLoading.style.display = 'block';
        inventoriesContainer.style.display = 'none';

        fetch(`<?= base_url('api/room-numbers') ?>/${roomNumberId}/inventories`)
            .then(r => r.json())
            .then(res => {
                inventoriesLoading.style.display = 'none';
                if (res.status === 'success' && res.data.length > 0) {
                    renderInventoriesTable(res.data);
                    inventoriesContainer.style.display = 'block';
                } else {
                    inventoriesContainer.innerHTML = '<div class="alert alert-warning text-center">Kamar ini belum memiliki inventaris standar yang dikonfigurasi Admin.</div>';
                    inventoriesContainer.style.display = 'block';
                }
            });
    }

    function renderInventoriesTable(categories) {
        let html = `
            <div class="card card-stat bg-white mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" style="font-size: 0.9rem;">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Nama Inventaris</th>
                                    <th width="90" class="text-center">Standar</th>
                                    <th width="110" class="text-center">Aktual</th>
                                    <th width="100" class="text-center">Selisih</th>
                                    <th width="320" class="text-center">Kondisi Fisik</th>
                                    <th>Keterangan / Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        let no = 1;
        categories.forEach(cat => {
            cat.items.forEach(item => {
                const itemId = item.inventory_item_id;
                const stdQty = item.standard_quantity;

                html += `
                    <tr>
                        <td class="text-center fw-bold">${no++}</td>
                        <td class="fw-bold text-dark">${item.inventory_name}</td>
                        <td class="text-center font-monospace fw-bold"><span class="badge bg-light text-dark border">${stdQty} ${item.unit}</span></td>
                        <td class="text-center p-1">
                            <input type="number" min="0" class="form-control form-control-sm text-center fw-bold actual-input" 
                                name="actual_quantity[${itemId}]" data-std="${stdQty}" data-item-id="${itemId}" value="${stdQty}" required>
                        </td>
                        <td class="text-center" id="diff_badge_${itemId}">
                            <span class="badge bg-success-subtle text-success">Sesuai</span>
                        </td>
                        <td class="p-1">
                            <div class="status-btn-group d-flex gap-1 justify-content-center">
                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_good_${itemId}" value="good" data-item-id="${itemId}" checked required>
                                <label class="btn btn-outline-success btn-sm" for="cond_good_${itemId}">Baik</label>

                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_damaged_${itemId}" value="damaged" data-item-id="${itemId}">
                                <label class="btn btn-outline-danger btn-sm" for="cond_damaged_${itemId}">Rusak</label>

                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_repair_${itemId}" value="need_repair" data-item-id="${itemId}">
                                <label class="btn btn-outline-warning btn-sm" for="cond_repair_${itemId}">Perbaikan</label>

                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_shortage_${itemId}" value="shortage" data-item-id="${itemId}">
                                <label class="btn btn-outline-secondary btn-sm" for="cond_shortage_${itemId}">Kurang</label>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm note-input" name="inventory_notes[${itemId}]" id="note_input_${itemId}" placeholder="Catatan jika ada masalah...">
                        </td>
                    </tr>
                `;
            });
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;

        inventoriesContainer.innerHTML = html;
        bindDynamicEvents();
    }

    function bindDynamicEvents() {
        // Actual Quantity Input Event -> Calculate Difference
        document.querySelectorAll('.actual-input').forEach(inp => {
            inp.addEventListener('input', function() {
                const itemId = this.dataset.itemId;
                const stdQty = parseInt(this.dataset.std);
                const actQty = parseInt(this.value) || 0;
                const diff   = actQty - stdQty;
                const diffBadge = document.getElementById('diff_badge_' + itemId);

                if (diff === 0) {
                    diffBadge.innerHTML = '<span class="badge bg-success-subtle text-success">Sesuai</span>';
                } else if (diff < 0) {
                    diffBadge.innerHTML = `<span class="badge bg-danger">Kurang ${Math.abs(diff)}</span>`;
                    // Automatically check shortage if lower
                    const shortageRadio = document.getElementById('cond_shortage_' + itemId);
                    if (shortageRadio) shortageRadio.checked = true;
                } else {
                    diffBadge.innerHTML = `<span class="badge bg-info text-dark">Lebih +${diff}</span>`;
                }
            });
        });

        // Condition radio toggle -> Note required
        document.querySelectorAll('.status-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const noteInput = document.getElementById('note_input_' + this.dataset.itemId);
                if (['damaged', 'need_repair', 'shortage'].includes(this.value)) {
                    noteInput.setAttribute('required', 'required');
                    noteInput.classList.add('border-danger');
                    noteInput.placeholder = 'Wajib diisi! Jelaskan kerusakan / penyebab kurang...';
                } else {
                    noteInput.removeAttribute('required');
                    noteInput.classList.remove('border-danger');
                    noteInput.placeholder = 'Catatan jika ada masalah...';
                }
            });
        });
    }

    if (roomSelect.value) loadRoomNumbers(roomSelect.value, "<?= old('room_number_id') ?>");
    roomSelect.addEventListener('change', function() { loadRoomNumbers(this.value); });
    roomNumberSelect.addEventListener('change', function() { loadRoomInventories(this.value); });

    // ===== 3. Photo Previews =====
    const patientPhotoInput = document.getElementById('patient_photo');
    if (patientPhotoInput) {
        patientPhotoInput.addEventListener('change', function() {
            const cont = document.getElementById('patient_photo_preview_container');
            const img = document.getElementById('patient_photo_preview');
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { img.src = e.target.result; cont.style.display = 'block'; };
                reader.readAsDataURL(this.files[0]);
            } else { cont.style.display = 'none'; }
        });
    }

    document.getElementById('room_photos_input').addEventListener('change', function() {
        const list = document.getElementById('room_photos_preview_list');
        list.innerHTML = '';
        Array.from(this.files).slice(0, 5).forEach((f, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const col = document.createElement('div');
                col.className = 'col-4 col-sm-3';
                col.innerHTML = `<div class="border rounded p-1 bg-white text-center"><img src="${e.target.result}" style="height:60px;width:100%;object-fit:cover;" class="rounded"><input type="text" class="form-control form-control-sm mt-1 p-0 text-center" name="room_photos_captions[]" placeholder="Ket Foto" style="font-size:0.65rem;"></div>`;
                list.appendChild(col);
            };
            reader.readAsDataURL(f);
        });
    });

    // ===== 4. SIGNATURE PADS =====
    const sigPads = {};
    ['sender', 'receiver', 'head'].forEach(type => {
        const canvas = document.getElementById('sigCanvas' + type.charAt(0).toUpperCase() + type.slice(1));
        const ctx = canvas.getContext('2d');
        const hiddenInput = document.getElementById('sig_data_' + type);
        let isDrawing = false;

        function resize() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            ctx.scale(ratio, ratio);
            ctx.strokeStyle = '#0f2c59';
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
        btn.addEventListener('click', () => sigPads[btn.dataset.target].clear());
    });

    // ===== 5. Form Submit Validation =====
    document.getElementById('handoverForm').addEventListener('submit', function(e) {
        if (!document.getElementById('sig_data_sender').value || !document.getElementById('sig_data_receiver').value) {
            e.preventDefault();
            alert('Harap isi Tanda Tangan Pihak Menyerahkan dan Pihak Menerima.');
            return false;
        }
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> MEMPROSES...';
    });
});
</script>
<?= $this->endSection() ?>
