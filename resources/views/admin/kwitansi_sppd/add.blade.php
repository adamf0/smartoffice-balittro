<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/admin/kwitansi_sppd/store" method="post">
                    {{ csrf_field() }}
            		<label>Nomor SPPD</label>
            		<select name="id_perjalanan_dinas" data-placeholder="Pilih Nomor SPPD" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($datas as $data)
                            <option value="{{ $data->id }}">{{ $data->nomor_perjalanan_dinas }}</option>
                        @endforeach
                    </select>
                    <label>Transport</label>
                    <input type="text" name="transport" class="form-control" placeholder="masukkan jumlah biaya transport" required>
                    <label>Penginapan dan Makan</label>
                    <input type="text" name="penginapan_makan" class="form-control" placeholder="masukkan jumlah biaya penginapan dan makan" required>
                    <label>Angkutan Setempat / Biaya Rill</label>
                    <input type="text" name="biaya_rill" class="form-control" placeholder="masukkan jumlah biaya angkutan / biaya rill" required>
                    <label>Uang Saku</label>
                    <input type="text" name="uang_saku" class="form-control" placeholder="masukkan jumlah biaya aung saku" required>

            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>