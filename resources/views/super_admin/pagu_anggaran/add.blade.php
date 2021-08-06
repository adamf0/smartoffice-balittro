<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/pagu_anggaran/store" method="post">
                    {{ csrf_field() }}
            		<label>Kode/MAK</label>
            		<input type="text" name="kode_kegiatan" class="form-control" required="true">
                    <label>Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="form-control" required="true">
                    <label>Penanggung Jawab</label>
                    <select name="penanggung_jawab" data-placeholder="Pilih Penanggung Jawab" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($data_user as $data_user)
                            <option value="{{ $data_user->id_user }}">{{ $data_user->nama ." - ".$data_user->nip }}</option>
                        @endforeach
                    </select>
                    <label>Total Pagu Anggaran</label>
                    <input type="number" name="total_biaya" class="form-control" required="true">
                    <label>Sisa Pagu Anggaran</label>
                    <input type="number" name="sisa_biaya" class="form-control" required="true">
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>