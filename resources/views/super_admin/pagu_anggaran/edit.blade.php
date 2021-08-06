<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/pagu_anggaran/update" method="post">
            		{{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Kode/MAK</label>
            		<input type="text" name="kode_kegiatan" class="form-control" value="{{ $data->kode }}" required="true">
                    <label>Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="form-control" value="{{ $data->nama_kegiatan }}" required="true">
                    <label>Penanggung Jawab</label>
                    <select name="penanggung_jawab" data-placeholder="Pilih Penanggung Jawab" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($data_user as $data_user)
                            <option value="{{ $data_user->id_user }}" @if($data_user->id_user==$data->id_user){{"selected"}}@endif >{{ $data_user->nama ." - ".$data_user->nip }}</option>
                        @endforeach
                    </select>
                    <label>Total Pagu Anggaran</label>
                    <input type="number" name="total_biaya" class="form-control" value="{{ $data->total_biaya }}" required="true">
                    <label>Sisa Pagu Anggaran</label>
                    <input type="number" name="sisa_biaya" class="form-control" value="{{ $data->sisa_biaya }}" required="true">
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>