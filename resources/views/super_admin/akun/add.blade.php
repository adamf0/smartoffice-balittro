<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/akun/store" method="post">
                    {{ csrf_field() }}
            		<label>Username</label>
            		<input type="text" name="username" class="form-control" required>
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                    <label>Level</label>
                    <select name="level" class="form-control" required>
                        @foreach($role as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>