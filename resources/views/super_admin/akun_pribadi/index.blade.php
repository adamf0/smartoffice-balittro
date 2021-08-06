<div class="row">
    @if (Session::has('type_msg'))
    <div class="col-12">
        @if(Session::get('type_msg')==0)
        <div class="alert alert-danger alert-block notif">
        @elseif(Session::get('type_msg')==1)
        <div class="alert alert-success alert-block notif">
        @endif
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ Session::get('msg') }}</strong>
        </div>
    </div>
    @endif  
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('/super_admin/akun_pribadi/ubah') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $data->username }}" required>
                    <label>Password <small>( menggunakan password lama jika tidak diisi )</small></label>
                    <input type="password" name="password" class="form-control" placeholder="masukkan password baru..." required>
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{ $data->email }}" required>
                    <small>Catatan: setelah update pastikan anda sudah menghapus pengingat akun anda dalam perangkat anda dan login kembali di perangkat anda</small>
                    <button type="submit" name="simpan" class="btn btn-primary btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>