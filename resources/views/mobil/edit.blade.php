@empty($mobil)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/mobil') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/mobil/' . $mobil->mobil_id . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Edit Data mobil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card m-4 p-2 bg-light">

                        <!-- Step 1 -->
                        <div class="tab">
                            <div class="card-header">
                                <h5>Data mobil</h5>
                            </div>
                            <div class="card-body">
                                <div class="form p-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Merk</label>
                                                <input type="text" name="merk" id="merk" class="form-control"
                                                    value="{{ $mobil->merk }}" required>
                                                <small id="error-merk" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Tahun</label>
                                                <input type="number" name="tahun" id="tahun" class="form-control"
                                                    value="{{ $mobil->tahun }}" required>
                                                <small id="error-tahun" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input type="number" name="harga" id="harga" class="form-control"
                                                    value="{{ $mobil->harga }}" required>
                                                <small id="error-harga" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select name="kategori_id" id="kategori" class="form-control" required>
                                                    <option value="">- Pilih kategori -</option>
                                                    @foreach ($kategori as $data)
                                                        <option
                                                            {{ $data->kategori_id == $mobil->kategori->kategori_id ? 'selected' : '' }}
                                                            value="{{ $data->kategori_id }}">
                                                            {{ $data->nama_kategori }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="error-kategori" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <input type="text" name="type" id="type" class="form-control"
                                                    value="{{ $mobil->type }}" required>
                                                <small id="error-type" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="image"
                                                            id="image" accept="image/*" onchange="preview()" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- File input for new image -->
                                    <div class="row">
                                        @if ($mobil->image)
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <h5>Image Lama</h5>
                                                    <div id="imgOld">
                                                        <img src="{{ asset('storage/' . $mobil->image) }}"
                                                            alt="Current Image" style="max-width: 100%;">
                                                    </div>

                                                </div>
                                            </div>
                                        @endif
                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <h5>Image Baru</h5>
                                                <div id="">
                                                    <img id="frame" src="" class="img-fluid my-3"
                                                        max-width="100%" alt="Preview gambar" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button class="btn bg-gradient-dark mx-2" type="button" onclick="clearImage()">Clear Image</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </div>
    </form>
    <!-- SCRIPT -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
        
        // Preview Gambar
        function preview() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }

        // Clear Gambar
        function clearImage() {
            document.getElementById('image').value = null;
            frame.src = "";
        }
    </script>
    <script>
        var isEdit = true;
        $(document).ready(function() {
            // 1. SETUP VALIDASI SEKALI SAJA
            $("#form-edit").validate({
                rules: {
                    merk: {
                        required: true,
                        minlength: 2,
                        maxlength: 100
                    },
                    tahun: {
                        required: true,
                        digits: true,
                        minlength: 4,
                        maxlength: 4
                    },
                    harga: {
                        required: true,
                        digits: true
                    },
                    type: {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    image: {
                        required: !isEdit,
                        extension: "jpg|jpeg|png|gif|svg"
                    },
                    kategori_id: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form); // Gunakan FormData, bukan serialize
                    formData.append('_method', 'PUT');

                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        processData: false, // Penting! Biar jQuery tidak serialize formData
                        contentType: false, // Penting! Biar jQuery set content-type multipart/form-data
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataMobil.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

@endempty
