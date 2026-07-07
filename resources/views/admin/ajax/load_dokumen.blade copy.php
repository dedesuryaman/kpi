<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUploadFile">
    Open Modal
</button>
<hr>
<div class="row g-2">
    @forelse($dokumens as $doc)
    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
        <div class="card text-center p-2 h-100 d-flex flex-column doc-card">
            <div class="mb-2">
                <i class="{{ $doc->icon_class }} fa-3x"></i>
            </div>

            <div class="doc-title" title="{{ $doc->file_name ?? $doc->title }}">
                @php
                $fileName = $doc->file_name ?? $doc->title;
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if(strlen($fileName) > 100){
                $fileName = substr($fileName, 0, 100) . '...' . strtoupper($ext);
                }
                @endphp
                {{ $fileName }}
            </div>

            <div class="doc-meta text-muted" style="font-size:.72rem;">
                {{ $doc->human_size }}
            </div>

            {{-- tombol actions --}}
            <div class="mt-auto d-flex justify-content-center gap-1 doc-actions">
                @if($doc->simple_type === 'image' || $doc->simple_type === 'pdf')
                <button class="btn btn-sm btn-outline-primary preview-btn" data-type="{{ $doc->simple_type }}"
                    data-url="{{ $doc->file_url }}">
                    <i class="fas fa-eye"></i>
                </button>
                @endif

                <a class="btn btn-sm btn-outline-success" href="{{ $doc->file_url }}" download>
                    <i class="fas fa-download"></i>
                </a>

                <a class="btn btn-sm btn-outline-secondary" href="{{ $doc->file_url }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-3">
        Belum ada file.
    </div>
    @endforelse
</div>

{{-- Preview Modal --}}
<div class="modal fade" id="dokPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dokPreviewTitle">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="dokPreviewBody" style="min-height:300px;"></div>
            <div class="modal-footer">
                <a id="dokPreviewDownload" class="btn btn-primary" href="#" download>
                    <i class="fas fa-download"></i> Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.preview-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.dataset.url;
                const type = this.dataset.type;
                const title = this.closest('.doc-card').querySelector('.doc-title').textContent.trim();

                const modalEl = document.getElementById('dokPreviewModal');
                const body = modalEl.querySelector('#dokPreviewBody');
                const t = modalEl.querySelector('#dokPreviewTitle');
                const dwn = modalEl.querySelector('#dokPreviewDownload');

                t.textContent = title;
                dwn.href = url;

                if (type === 'image') {
                    body.innerHTML = `<img src="${url}" alt="${title}" class="img-fluid" style="max-height:70vh;">`;
                } else if (type === 'pdf') {
                    body.innerHTML = `<iframe src="${url}" frameborder="0" style="width:100%; height:70vh;"></iframe>`;
                } else {
                    body.innerHTML = `<div class="p-4">Preview tidak tersedia. <a href="${url}" target="_blank">Buka di tab baru</a></div>`;
                }

                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });
        });
    });
</script>
<!-- Modal Upload File -->
<div class="modal fade" id="modalUploadFile" tabindex="-1" aria-labelledby="uploadFileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileLabel">Upload File Pekerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="uploadFileForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id }}">
                    <input type="hidden" name="uploaded_by" value="{{ auth()->id() }}">

                    <div class="mb-3">
                        <label class="form-label">Judul File</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="category_id" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File</label>
                        <input type="file" class="form-control" name="file_path" required>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress" style="height: 12px; display:none;" id="uploadProgressBox">
                        <div id="uploadProgress" class="progress-bar bg-primary" role="progressbar" style="width: 0%">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload File</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).off("submit", "#uploadFileForm").on("submit", "#uploadFileForm", function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $("#uploadProgressBox").show();
            $("#uploadProgress").css("width", "0%");

            $.ajax({
                url: "{{ url('/ajax/file-dokumen-pekerjaan/upload') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            let percent = Math.round((evt.loaded / evt.total) * 100);
                            $("#uploadProgress").css("width", percent + "%");
                        }
                    });
                    return xhr;
                },
                success: function(res) {
                    toastr.success("File berhasil diupload!");
                    $("#modalUploadFile").modal("hide");
                    $("#uploadFileForm")[0].reset();
                    $("#uploadProgressBox").hide();

                    if (typeof loadPageDiv === "function") {

                        loadPageDiv('/ajax/pekerjaan/load-dokumen-pekerjaan/{{$pekerjaan->id }}', '#contentDokumen');
                    }
                },
                error: function(xhr) {
                    toastr.error("Gagal upload file");
                    $("#uploadProgressBox").hide();
                }
            });

        });
    })
</script>