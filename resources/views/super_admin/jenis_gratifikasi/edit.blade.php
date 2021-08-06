<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/jenis_gratifikasi/update" method="post">
            		{{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Nama Jenis Gratifikasi</label>
            		<input type="text" name="nama_jenis_gratifikasi" class="form-control" value="{{ $data->nama }}" required>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>