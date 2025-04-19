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
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data mobil</h5>

                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data mobil</h5>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Kategori</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->kategori->nama_kategori }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Merk</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->merk }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Tahun</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->tahun }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Harga</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->harga }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Type</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->type }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Status</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->status }}</td>
                    </tr>
                </table>

                <h5 class="modal-title" id="exampleModalLabel">Detail Spesifikasi mobil</h5>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Usia</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->detail->usia }} Tahun</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Kilometer</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->detail->kilometer }} KM</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Cylinder</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->detail->cylinder }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">No Mesin</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->detail->no_mesin }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Transmisi</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->detail->transmisi }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">HP</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->detail->hp }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Warna</th>
                        <td>:</td>
                        <td class="col-9">{{ $mobil->detail->warna }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
            </div>
        </div>
    </div>
@endempty
