@empty($spesifikasi)
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
                <a href="{{ url('/spesifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/mobil/spesifikasi/' . $spesifikasi->detail_mobil_id . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Edit Data spesifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card m-4 p-2 bg-light">

                        <div class="tab">
                            <div class="card-header">
                                <h5>Spesifikasi Mobil</h5>
                            </div>
                            <div class="card-body">
                                <div class="form p-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Cylinder</label>
                                                <input type="text" name="cylinder" id="cylinder" class="form-control"
                                                    value="{{ $spesifikasi->cylinder }}" required>
                                                <small id="error-cylinder" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>No Mesin</label>
                                                <input type="text" name="no_mesin" id="no_mesin" class="form-control"
                                                    value="{{ $spesifikasi->no_mesin }}" required>
                                                <small id="error-no_mesin" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Kilometer</label>
                                                <input type="number" name="kilometer" id="kilometer" class="form-control"
                                                    value="{{ $spesifikasi->kilometer }}" required>
                                                <small id="error-kilometer"
                                                    class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>House Power</label>
                                                <input type="number" name="hp" id="hp" class="form-control"
                                                    value="{{ $spesifikasi->hp }}" required>
                                                <small id="error-hp" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Warna</label>
                                                <input type="text" name="warna" id="warna" class="form-control"
                                                    value="{{ $spesifikasi->warna }}" required>
                                                <small id="error-warna" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Usia</label>
                                                <input type="number" name="usia" id="usia" class="form-control"
                                                    value="{{ $spesifikasi->usia }}" required>
                                                <small id="error-usia" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Transmisi</label>
                                                <input type="text" name="transmisi" id="transmisi" class="form-control"
                                                    value="{{ $spesifikasi->transmisi }}" required>
                                                <small id="error-transmisi"
                                                    class="error-text form-text text-danger"></small>
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
                    <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            // 1. SETUP VALIDASI SEKALI SAJA
            $("#form-edit").validate({
                rules: {
                    usia: {
                        required: true,
                    },
                    kilometer: {
                        required: true,
                    },
                    cylinder: {
                        required: true,
                    },
                    no_mesin: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    transmisi: {
                        required: true,
                    },
                    hp: {
                        required: true,
                    },
                    warna: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
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
