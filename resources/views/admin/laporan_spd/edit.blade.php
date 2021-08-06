<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/admin/laporan_spd/update" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $spd->id }}">
                    <label>Nomor Laporan SPPD</label>
                    <select name="id_perjalanan_dinas" data-placeholder="Pilih Nomor SPPD" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($datas as $data)
                            <option value="{{ $data->id }}" @if($data->id==$spd->id_perjalanan_dinas) {{ "selected='true'" }} @endif>{{ $data->nomor_perjalanan_dinas }}</option>
                        @endforeach
                    </select>
                    <label>Tempat Berangkat</label>
                    <input type="text" name="tempat_berangkat" class="form-control" value="{{ $spd->tempat_berangkat }}" required>
                    <label>Keterangan</label>
                    <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="radio" id="pilihan_0" name="keterangan" required value="1" @if($spd->keterangan==1) {{ "checked='true'" }} @endif>
                        <label for="pilihan_0">Tanggal Harus Kembali</label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="pilihan_1" name="keterangan" required value="0" @if($spd->keterangan==0) {{ "checked='true'" }} @endif>
                        <label for="pilihan_1">Tiba Di Tempat Baru</label>
                      </div>
                    </div>
                    <label>Keterangan Lain</label>
                    <input type="text" name="keterangan_lain" class="form-control" value="{{ $spd->keterangan_lain }}" required>

            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>