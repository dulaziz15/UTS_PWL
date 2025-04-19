<form action="{{ url('/mobil/create') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card m-4 p-2 bg-light">

                    <!-- Step 1 -->
                    <div class="tab" style="display: none;">
                        <div class="card-header">
                            <h5>Data User</h5>
                        </div>
                        <div class="card-body">
                            <div class="form p-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Merk</label>
                                            <input type="text" name="merk" id="merk" class="form-control"
                                                required>
                                            <small id="error-merk" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="number" name="tahun" id="tahun" class="form-control"
                                                required>
                                            <small id="error-tahun" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="number" name="harga" id="harga" class="form-control"
                                                required>
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
                                                    <option value="{{ $data->kategori_id }}">{{ $data->nama_kategori }}
                                                    </option>
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
                                                required>
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
                                <div class="row">
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <img id="frame" src="" class="img-fluid my-3" max-width="100%"
                                                alt="Preview gambar" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="tab" style="display: none;">
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
                                                required>
                                            <small id="error-cylinder"
                                                class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>No Mesin</label>
                                            <input type="text" name="no_mesin" id="no_mesin"
                                                class="form-control" required>
                                            <small id="error-no_mesin"
                                                class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Kilometer</label>
                                            <input type="number" name="kilometer" id="kilometer"
                                                class="form-control" required>
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
                                                required>
                                            <small id="error-hp" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Warna</label>
                                            <input type="text" name="warna" id="warna" class="form-control"
                                                required>
                                            <small id="error-warna" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Usia</label>
                                            <input type="number" name="usia" id="usia" class="form-control"
                                                required>
                                            <small id="error-usia" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Transmisi</label>
                                            <input type="text" name="transmisi" id="transmisi"
                                                class="form-control" required>
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
                <button class="btn bg-gradient-dark mx-2" type="button" onclick="clearImage()">Clear Image</button>
                <button type="button" id="prevBtn" class="btn btn-secondary"
                    onclick="nextPrev(-1)">Previous</button>
                <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">Next</button>
                <button type="submit" id="submitBtn" class="btn btn-primary" style="display: none;">Simpan</button>
            </div>

        </div>
    </div>
</form>
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
<!-- SCRIPT -->
<script>
    // Form Step
    var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        document.getElementById("prevBtn").style.display = (n == 0) ? "none" : "inline";
        document.getElementById("nextBtn").style.display = (n == (x.length - 1)) ? "none" : "block";
        document.getElementById("submitBtn").style.display = (n == (x.length - 1)) ? "block" : "none";
    }

    $(document).ready(function() {
        // 1. SETUP VALIDASI SEKALI SAJA
        $("#form-tambah").validate({
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
                    required: true,
                    extension: "jpg|jpeg|png|gif|svg"
                },
                kategori_id: {
                    required: true
                },
                usia: {
                    required: true,
                    digits: true
                },
                kilometer: {
                    required: true,
                    digits: true
                },
                cylinder: {
                    required: true,
                    digits: true
                },
                no_mesin: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                transmisi: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                hp: {
                    required: true,
                    digits: true
                },
                warna: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form); // Gunakan FormData, bukan serialize

                $.ajax({
                    url: form.action,
                    type: form.method,
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

    // 2. NEXT PREV FUNGSINYA
    function nextPrev(n) {
        var x = document.getElementsByClassName("tab");
        if (n == 1 && !validateForm()) return false; // Validate current step
        x[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= x.length) {
            // SUDAH STEP TERAKHIR
            if ($("#form-tambah").valid()) { // Cek semua form valid gak
            }
            return false;
        }
        showTab(currentTab);
    }


    function validateForm() {
        var valid = true;
        var x = document.getElementsByClassName("tab")[currentTab];
        var inputs = x.getElementsByTagName("input");

        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].hasAttribute('required') && inputs[i].value == "") {
                inputs[i].classList.add("is-invalid");
                valid = false;
            } else {
                inputs[i].classList.remove("is-invalid");
            }
        }
        return valid;
    }
</script>
