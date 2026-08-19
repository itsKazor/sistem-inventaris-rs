<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4 mx-auto" style="max-width: 1320px;" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-2 align-middle"></i>
        <span><?= html_escape($this->session->flashdata('error')) ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form id="handoverForm" action="<?= base_url('serah-terima/save') ?>" method="post" enctype="multipart/form-data">

    <div class="paper-document">

        <!-- ========== DOCUMENT HEADER ========== -->
        <div class="row align-items-center mb-0">
            <div class="col-md-5 mb-3 mb-md-0 d-flex align-items-center">
                <img src="<?= base_url('assets/images/logo_rs.png') ?>" alt="RSU Catharina 1914" style="height: 64px; width: auto; object-fit: contain;">
            </div>
            <div class="col-md-7">
                <div class="doc-header-title shadow-sm">
                    FORM SERAH TERIMA & INVENTARIS KAMAR<br>RSU CATHARINA 1914
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- ========== METADATA HEADER ========== -->
        <div class="row g-3 mb-4" style="font-size: .92rem;">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label mb-1 d-block">Ruang Perawatan</label>
                    <select class="form-select form-select-sm" id="room_id" name="room_id" required>
                        <option value="">-- Pilih Ruang --</option>
                        <?php foreach ($rooms as $room): ?>
                            <option value="<?= $room['id'] ?>"><?= html_escape($room['name']) ?> (<?= html_escape($room['code']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label mb-1 d-block">Nomor Kamar</label>
                    <select class="form-select form-select-sm" id="room_number_id" name="room_number_id" required disabled>
                        <option value="">-- Pilih Ruang Dulu --</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label mb-1 d-block">Tanggal Serah Terima</label>
                    <input type="date" class="form-control form-control-sm" id="handover_date" name="handover_date" value="<?= isset($currentDate) ? $currentDate : date('Y-m-d') ?>" required>
                </div>
                <div>
                    <label class="form-label mb-1 d-block">Waktu Serah Terima</label>
                    <input type="time" class="form-control form-control-sm" id="handover_time" name="handover_time" value="<?= isset($currentTime) ? $currentTime : date('H:i') ?>" required>
                </div>
            </div>
        </div>

        <!-- ========== 1. IDENTITAS ========== -->
        <div class="doc-section-title"><i class="bi bi-people-fill me-2"></i>1. Identitas Serah Terima</div>

        <table class="doc-table mb-4">
            <thead>
                <tr>
                    <th width="50%" class="text-center">Pihak yang Menyerahkan</th>
                    <th width="50%" class="text-center">Pihak yang Menerima</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-3">
                        <div class="mb-3">
                            <label class="form-label mb-1">Nama Lengkap Penyerah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="sender_name" placeholder="Nama penyerah" required>
                        </div>
                        <div>
                            <label class="form-label mb-1 text-muted">Jabatan / Role (Optional)</label>
                            <input type="text" class="form-control form-control-sm" name="sender_position" placeholder="Contoh: Shift Pagi / Katim">
                        </div>
                    </td>
                    <td class="p-3">
                        <div class="mb-3">
                            <label class="form-label mb-1">Nama Lengkap Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="receiver_name" placeholder="Nama penerima" required>
                        </div>
                        <div>
                            <label class="form-label mb-1 text-muted">Jabatan / Role (Optional)</label>
                            <input type="text" class="form-control form-control-sm" name="receiver_position" placeholder="Contoh: Shift Sore">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- ========== 2. CHECKLIST INVENTARIS STANDAR & KONDISI AKTUAL ========== -->
        <div class="doc-section-title"><i class="bi bi-ui-checks me-2"></i>2. Checklist Inventaris Kamar & Kondisi Aktual</div>

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

        <!-- ========== 3. FOTO PASIEN & CATATAN (GRID) ========== -->
        <div class="doc-section-title"><i class="bi bi-camera-fill me-2"></i>3. Foto Pasien & Catatan / Hal Penting</div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="border rounded p-3 bg-light h-100">
                    <label class="form-label mb-1">
                        <i class="bi bi-person-bounding-box me-1 text-info"></i> Foto Pasien
                        <span class="badge bg-danger ms-1" style="font-size: .65rem;">Rahasia / Admin Only</span>
                        <span class="badge bg-primary ms-1" style="font-size: .65rem;">Wajib</span>
                    </label>
                    <div class="text-muted small mb-2">Aktifkan kamera, arahkan ke wajah pasien, lalu tekan "Ambil Foto".</div>

                    <!-- LIVE CAMERA PREVIEW & NATIVE FALLBACK -->
                    <div id="camera_container">
                        <div class="position-relative mb-2">
                            <video id="camera_preview" autoplay playsinline muted style="width:100%; border-radius:10px; border:1px solid #cbd5e1; background:#000;"></video>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" id="camera_start_btn" class="btn btn-primary w-100 py-2 fw-bold">
                                <i class="bi bi-camera-video me-2"></i> Buka Kamera
                            </button>
                            <button type="button" id="camera_capture_btn" class="btn btn-success w-100 py-2 fw-bold" style="display:none;">
                                <i class="bi bi-camera-fill me-2"></i> Ambil Foto
                            </button>
                        </div>
                        <input type="file" id="fallback_camera_input" accept="image/*" capture="environment" style="display:none;">
                    </div>

                    <!-- CAPTURED PHOTO PREVIEW -->
                    <div id="patient_photo_preview_container" style="display: none;" class="mt-2 text-center">
                        <img id="patient_photo_preview" src="" alt="Preview Foto Pasien" class="img-fluid rounded border bg-white" style="max-width: 100%; max-height: 260px;">
                        <small class="text-success fw-semibold d-block mt-1"><i class="bi bi-check-circle-fill me-1"></i>Foto berhasil diambil</small>
                        <button type="button" id="camera_retake_btn" class="btn btn-outline-secondary btn-sm mt-2">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Ambil Ulang
                        </button>
                    </div>

                    <div id="camera_error" class="alert alert-danger py-2 mt-2 mb-0 small" style="display: none;"></div>
                    <input type="hidden" id="patient_photo_data" name="patient_photo_data">
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded p-3 bg-light h-100">
                    <label class="form-label mb-1">
                        <i class="bi bi-journal-text me-1 text-info"></i> Catatan / Hal Penting
                    </label>
                    <div class="text-muted small mb-2">Tuliskan catatan khusus, temuan kondisi fasilitas, atau pesan operasional antar-shift...</div>
                    <textarea class="form-control" name="notes" rows="3" style="min-height: 200px;" placeholder="Tuliskan catatan khusus, temuan kondisi fasilitas, atau pesan operasional antar-shift..."></textarea>
                </div>
            </div>
        </div>

        <!-- ========== 4. TANDA TANGAN DIGITAL ========== -->
        <div class="doc-section-title"><i class="bi bi-pen-fill me-2"></i>4. Tanda Tangan Digital</div>

        <div class="row g-3 mb-4">
            <!-- TTD Menyerahkan -->
            <div class="col-lg-4 col-md-6">
                <div class="border rounded p-3 bg-white text-center h-100 d-flex flex-column shadow-sm">
                    <div class="fw-bold text-dark mb-1" style="font-size: .9rem;">Pihak Menyerahkan <span class="text-danger">*</span></div>
                    <div class="text-muted small mb-2">(Penyerah)</div>
                    <div class="signature-box flex-grow-1 mb-2" style="min-height: 140px;">
                        <canvas id="sigCanvasSender" class="sig-canvas" style="width:100%; height:140px;"></canvas>
                    </div>
                    <input type="hidden" name="signature_data_sender" id="sig_data_sender">
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2 clear-sig-btn" data-target="sender"><i class="bi bi-eraser me-1"></i> Hapus Signature</button>
                </div>
            </div>

            <!-- TTD Menerima -->
            <div class="col-lg-4 col-md-6">
                <div class="border rounded p-3 bg-white text-center h-100 d-flex flex-column shadow-sm">
                    <div class="fw-bold text-dark mb-1" style="font-size: .9rem;">Pihak Menerima <span class="text-danger">*</span></div>
                    <div class="text-muted small mb-2">(Penerima)</div>
                    <div class="signature-box flex-grow-1 mb-2" style="min-height: 140px;">
                        <canvas id="sigCanvasReceiver" class="sig-canvas" style="width:100%; height:140px;"></canvas>
                    </div>
                    <input type="hidden" name="signature_data_receiver" id="sig_data_receiver">
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2 clear-sig-btn" data-target="receiver"><i class="bi bi-eraser me-1"></i> Hapus Signature</button>
                </div>
            </div>

            <!-- TTD Mengetahui (Optional) -->
            <div class="col-lg-4 col-md-12">
                <div class="border rounded p-3 bg-white text-center h-100 d-flex flex-column shadow-sm">
                    <div class="fw-bold text-dark mb-1" style="font-size: .9rem;">Mengetahui <span class="text-muted fw-normal">(Optional)</span></div>
                    <div class="text-muted small mb-2">(Kepala Ruangan)</div>
                    <div class="signature-box flex-grow-1 mb-2" style="min-height: 140px;">
                        <canvas id="sigCanvasHead" class="sig-canvas" style="width:100%; height:140px;"></canvas>
                    </div>
                    <input type="hidden" name="signature_data_head" id="sig_data_head">
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2 clear-sig-btn" data-target="head"><i class="bi bi-eraser me-1"></i> Hapus Signature</button>
                </div>
            </div>
        </div>

        <!-- ========== 5. PERNYATAAN ========== -->
        <div class="doc-section-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>5. Pernyataan</div>

        <p class="statement-text mb-3">
            Dengan ini kami menyatakan bahwa serah terima ruang ini telah dilakukan dengan kondisi sebagaimana tercantum di atas.
        </p>

        <div class="alert-danger-hospital mb-4 text-center">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            Apabila terjadi kehilangan atau kerusakan terhadap fasilitas yang ada di ruangan, <span class="fw-bold text-danger">pasien wajib mengganti</span>.
        </div>

        <div class="form-check p-3 bg-light rounded border mb-4">
            <input class="form-check-input ms-0 me-3" type="checkbox" name="statement" id="statementCheck" value="1" style="width: 1.5em; height: 1.5em;" required>
            <label class="form-check-label fw-bold text-dark" for="statementCheck" style="font-size: .92rem;">
                Saya mengonfirmasi bahwa seluruh data serah terima inventaris telah sesuai dan siap disimpan ke sistem.
            </label>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="row g-2 mb-3">
            <div class="col-4">
                <button type="reset" id="resetBtn" class="btn btn-light border text-secondary w-100 py-3 fw-bold">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Form
                </button>
            </div>
            <div class="col-8">
                <button type="submit" id="submitBtn" class="btn btn-primary w-100 py-3 fw-bold fs-5 shadow">
                    <i class="bi bi-send-check me-2"></i> Kirim Serah Terima
                </button>
            </div>
        </div>

    </div>
</form>

<script>
const baseUrl = '<?= base_url() ?>';

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

        fetch(baseUrl + 'api/rooms/' + roomId + '/room-numbers')
            .then(r => r.json())
            .then(res => {
                const dataList = res.data || res;
                if (dataList.length > 0) {
                    let opts = '<option value="">-- Pilih Kamar --</option>';
                    dataList.forEach(d => {
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

        fetch(baseUrl + 'api/room-numbers/' + roomNumberId + '/inventories')
            .then(r => r.json())
            .then(res => {
                inventoriesLoading.style.display = 'none';
                const categories = res.data || res;
                if (categories.length > 0) {
                    renderInventoriesTable(categories);
                    inventoriesContainer.style.display = 'block';
                } else {
                    inventoriesContainer.innerHTML = '<div class="alert alert-warning text-center">Kamar ini belum memiliki inventaris standar yang dikonfigurasi Admin.</div>';
                    inventoriesContainer.style.display = 'block';
                }
            });
    }

    function renderInventoriesTable(categories) {
        let html = `
            <div class="card mb-4 border">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" style="font-size: .88rem; width: 100%;">
                            <thead>
                                <tr class="table-light">
                                    <th width="40" class="text-center">No</th>
                                    <th style="min-width: 140px;">Nama Inventaris</th>
                                    <th width="80" class="text-center">Standar</th>
                                    <th width="90" class="text-center">Aktual</th>
                                    <th width="90" class="text-center">Selisih</th>
                                    <th style="width: 280px; min-width: 270px;" class="text-center">Kondisi Fisik</th>
                                    <th style="min-width: 180px;">Keterangan / Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        let no = 1;
        categories.forEach(cat => {
            const items = cat.items || [cat];
            items.forEach(item => {
                const itemId = item.inventory_item_id || item.id;
                const stdQty = item.standard_quantity || 1;
                const invName = item.inventory_name || item.name;
                const invUnit = item.inventory_unit || item.unit || 'unit';

                html += `
                    <tr>
                        <td class="text-center fw-bold">${no++}</td>
                        <td class="fw-semibold text-dark">${invName}</td>
                        <td class="text-center font-monospace fw-bold"><span class="badge bg-light text-dark border">${stdQty} ${invUnit}</span></td>
                        <td class="text-center p-1">
                            <input type="number" min="0" class="form-control form-control-sm text-center fw-bold actual-input" 
                                name="actual_quantity[${itemId}]" data-std="${stdQty}" data-item-id="${itemId}" value="${stdQty}" required style="min-height:36px;">
                        </td>
                        <td class="text-center" id="diff_badge_${itemId}">
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Sesuai</span>
                        </td>
                        <td class="p-1">
                            <div class="status-btn-group">
                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_good_${itemId}" value="good" data-item-id="${itemId}" checked required>
                                <label class="btn btn-outline-success" for="cond_good_${itemId}">Baik</label>

                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_damaged_${itemId}" value="damaged" data-item-id="${itemId}">
                                <label class="btn btn-outline-danger" for="cond_damaged_${itemId}">Rusak</label>

                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_repair_${itemId}" value="need_repair" data-item-id="${itemId}">
                                <label class="btn btn-outline-warning" for="cond_repair_${itemId}">Perbaikan</label>

                                <input type="radio" class="btn-check status-radio" name="condition[${itemId}]" id="cond_shortage_${itemId}" value="shortage" data-item-id="${itemId}">
                                <label class="btn btn-outline-secondary" for="cond_shortage_${itemId}">Kurang</label>
                            </div>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm note-input" name="inventory_notes[${itemId}]" id="note_input_${itemId}" placeholder="Catatan jika ada masalah..." style="min-height:36px;">
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
        document.querySelectorAll('.actual-input').forEach(inp => {
            inp.addEventListener('input', function() {
                const itemId = this.dataset.itemId;
                const stdQty = parseInt(this.dataset.std);
                const actQty = parseInt(this.value) || 0;
                const diff   = actQty - stdQty;
                const diffBadge = document.getElementById('diff_badge_' + itemId);

                if (diff === 0) {
                    diffBadge.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle">Sesuai</span>';
                } else if (diff < 0) {
                    diffBadge.innerHTML = `<span class="badge bg-danger">Kurang ${Math.abs(diff)}</span>`;
                    const shortageRadio = document.getElementById('cond_shortage_' + itemId);
                    if (shortageRadio) shortageRadio.checked = true;
                } else {
                    diffBadge.innerHTML = `<span class="badge bg-info text-dark">Lebih +${diff}</span>`;
                }
            });
        });

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

    roomSelect.addEventListener('change', function() { loadRoomNumbers(this.value); });
    roomNumberSelect.addEventListener('change', function() { loadRoomInventories(this.value); });

    // ===== 3. Live Camera Capture =====
    const cameraStartBtn   = document.getElementById('camera_start_btn');
    const cameraCaptureBtn = document.getElementById('camera_capture_btn');
    const cameraRetakeBtn  = document.getElementById('camera_retake_btn');
    const cameraVideo      = document.getElementById('camera_preview');
    const cameraError      = document.getElementById('camera_error');
    const cameraContainer  = document.getElementById('camera_container');
    const photoPreviewCont = document.getElementById('patient_photo_preview_container');
    const photoPreviewImg  = document.getElementById('patient_photo_preview');
    const photoDataInput   = document.getElementById('patient_photo_data');

    let cameraStream = null;

    const fallbackCameraInput = document.getElementById('fallback_camera_input');

    function stopCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(t => t.stop());
            cameraStream = null;
        }
        cameraVideo.srcObject = null;
    }

    async function openCamera() {
        cameraError.style.display = 'none';
        
        // If navigator.mediaDevices is not available (HTTP connection on mobile), use native camera fallback
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            fallbackCameraInput.click();
            return;
        }

        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment', width: { ideal: 1280 } },
                audio: false,
            });
            cameraVideo.srcObject = cameraStream;
            cameraStartBtn.style.display = 'none';
            cameraCaptureBtn.style.display = '';
            await cameraVideo.play();
        } catch (err) {
            // Fallback to native camera input on error/permission deny
            fallbackCameraInput.click();
        }
    }

    fallbackCameraInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                photoDataInput.value = evt.target.result;
                photoPreviewImg.src = evt.target.result;
                photoPreviewCont.style.display = 'block';
                cameraContainer.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    cameraStartBtn.addEventListener('click', openCamera);

    cameraCaptureBtn.addEventListener('click', function() {
        if (!cameraStream) return;
        const canvas = document.createElement('canvas');
        canvas.width  = cameraVideo.videoWidth;
        canvas.height = cameraVideo.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);
        photoDataInput.value = canvas.toDataURL('image/png');
        photoPreviewImg.src = photoDataInput.value;
        photoPreviewCont.style.display = 'block';
        cameraContainer.style.display = 'none';
        stopCamera();
    });

    cameraRetakeBtn.addEventListener('click', function() {
        photoDataInput.value = '';
        photoPreviewImg.src = '';
        photoPreviewCont.style.display = 'none';
        cameraContainer.style.display = '';
        openCamera();
    });

    window.addEventListener('beforeunload', stopCamera);

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
            ctx.strokeStyle = '#2563eb';
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
        if (!photoDataInput.value) {
            e.preventDefault();
            alert('Foto pasien wajib diambil terlebih dahulu.');
            return false;
        }
        stopCamera();
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> MEMPROSES...';
    });
});
</script>
