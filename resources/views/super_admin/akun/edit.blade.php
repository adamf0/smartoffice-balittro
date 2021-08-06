<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/akun/update" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $data->username }}" required>
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $data->email }}" required>
                    <label>Level</label>
                    <select name="level" class="form-control" required>
                        <option value=""></option>
                        @foreach($role as $role)
                            <option value="{{ $role->id }}" @if($data->id_role==$role->id) {{ "selected='true'" }}  @endif >{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>