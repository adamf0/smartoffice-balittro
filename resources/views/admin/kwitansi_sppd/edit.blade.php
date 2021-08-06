<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="/admin/kwitansi_sppd/update" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $kwitansi->id }}">
                    <label>Nomor SPPD</label>
                    <select name="id_perjalanan_dinas" data-placeholder="Pilih Nomor SPPD" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($datas as $data)
                            <option value="{{ $data->id }}" @if($data->id == $kwitansi->id_perjalanan_dinas) {{ "selected='true'" }} @endif>{{ $data->nomor_perjalanan_dinas }}</option>
                        @endforeach
                    </select>
                    <label>Transport</label>
                    <input type="text" name="transport" class="form-control" placeholder="masukkan jumlah biaya transport" value="{{ $kwitansi->transport }}" required>
                    <label>Penginapan dan Makan</label>
                    <input type="text" name="penginapan_makan" class="form-control" placeholder="masukkan jumlah biaya penginapan dan makan" value="{{ $kwitansi->penginapan_makan }}" required>
                    <label>Angkutan Setempat / Biaya Rill</label>
                    <input type="text" name="biaya_rill" class="form-control" placeholder="masukkan jumlah biaya angkutan / biaya rill" value="{{ $kwitansi->biaya_rill }}" required>
                    <label>Uang Saku</label>
                    <input type="text" name="uang_saku" class="form-control" placeholder="masukkan jumlah biaya aung saku" value="{{ $kwitansi->uang_saku }}" required>

                    <button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>