<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/admin/laporan_spd/store" method="post">
                    {{ csrf_field() }}
                    <label>Nomor Laporan SPPD</label>
                    <select name="id_perjalanan_dinas" data-placeholder="Pilih Nomor SPPD" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($datas as $data)
                            <option value="{{ $data->id }}">{{ $data->nomor_perjalanan_dinas }}</option>
                        @endforeach
                    </select>
                    <label>Tempat Berangkat</label>
                    <input type="text" name="tempat_berangkat" class="form-control" required>
                    <label>Keterangan</label>
                    <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="radio" id="pilihan_0" name="keterangan" value="1" required>
                        <label for="pilihan_0">Tanggal Harus Kembali</label>
                      </div>
                      <div class="icheck-danger d-inline">
                        <input type="radio" id="pilihan_1" name="keterangan" value="0" required>
                        <label for="pilihan_1">Tiba Di Tempat Baru</label>
                      </div>
                    </div>
                    <label>Keterangan Lain</label>
                    <input type="text" name="keterangan_lain" class="form-control" placeholder="masukkan ketarangan lainnya" required>

            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>