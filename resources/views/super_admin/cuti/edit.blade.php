<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('/super_admin/cuti/update') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" disabled="true" placeholder="Masukkan NIP" value="{{ $data->nip }}" required>
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" disabled="true" placeholder="Masukkan Nama" value="{{ $data->nama }}" required>
                    <label>Total Cuti N <small>(hari)</small></label>
                    <input type="number" name="cuti_n" class="form-control" placeholder="Masukkan Cuti N" value="{{ $data->cuti_n }}" required min="0">
                    <label>Total Cuti N-1 <small>(hari)</small></label>
                    <input type="number" name="cuti_n1" class="form-control" placeholder="Masukkan Cuti N-1" value="{{ $data->cuti_n1 }}" required min="0">
                    <label>Total Cuti N-2 <small>(hari)</small></label>
                    <input type="number" name="cuti_n2" class="form-control" placeholder="Masukkan Cuti N-2" value="{{ $data->cuti_n2 }}" required min="0">

                    <button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>