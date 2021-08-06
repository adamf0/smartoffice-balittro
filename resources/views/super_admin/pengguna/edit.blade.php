<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('/super_admin/pengguna/update') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Akun</label>
                    <select name="akun" data-placeholder="Pilih Akun" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($akun as $akun)
                            <option value="{{ $akun->id }}" @if($data->id_user==$akun->id) {{ "selected='true'" }}  @endif>{{ $akun->username ." (".$akun->role->name.")"}}</option>
                        @endforeach
                    </select>
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" value="{{ $data->nip }}" required="true">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" value="{{ $data->nama }}" required="true">
                    <label>Agama</label>
                    <select name="agama" data-placeholder="Pilih Agama" class="form-control chosen-select" required="true">
                        <option value=""></option>
                        @foreach($agama as $agama)
                            <option value="{{ $agama->id }}" @if($data->id_agama==$agama->id) {{ "selected='true'" }}  @endif>{{ $agama->agama }}</option>
                        @endforeach
                    </select>
                    <label>Jenjang Pendidikan</label>
                    <select name="jenjang_pendidikan" data-placeholder="Pilih Jenjang Pendidikan" class="form-control chosen-select" required="true">
                        <option value=""></option>
                        @foreach($pendidikan as $pendidikan)
                            <option value="{{ $pendidikan->id }}" @if($data->id_jenjang_pendidikan==$pendidikan->id) {{ "selected='true'" }}  @endif>{{ $pendidikan->jenjang_pendidikan }}</option>
                        @endforeach
                    </select>
                    <label>Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" class="form-control" placeholder="Masukkan Nama Sekolah" value="{{ $data->nama_sekolah }}" required="true">
                    <label>Tahun Lulus</label>
                    <input type="text" name="tahun_lulus" class="form-control" placeholder="Masukkan Tahun Lulus" value="{{ $data->tahun_lulus }}" required="true">
                    <label>Jabatan</label>
                    <select name="jabatan" data-placeholder="Pilih Jabatan" class="form-control chosen-select" required="true">
                        <option value=""></option>
                        @foreach($jabatan as $jabatan)
                            <option value="{{ $jabatan->id }}" @if($data->id_jabatan==$jabatan->id) {{ "selected='true'" }}  @endif>{{ $jabatan->jabatan }}</option>
                        @endforeach
                    </select>
                    <label>Pangkat</label>
                    <select name="pangkat" data-placeholder="Pilih Pangkat" class="form-control chosen-select" required="true">
                        <option value=""></option>
                        @foreach($pangkat as $pangkat)
                            <option value="{{ $pangkat->id }}" @if($data->id_pangkat==$pangkat->id) {{ "selected='true'" }}  @endif>{{ $pangkat->pangkat }}</option>
                        @endforeach
                    </select>
                    <label>Golongan</label>
                    <select name="golongan" data-placeholder="Pilih Golongan" class="form-control chosen-select" required="true">
                        <option value=""></option>
                        @foreach($golongan as $golongan)
                            <option value="{{ $golongan->id }}" @if($data->id_golongan==$golongan->id) {{ "selected='true'" }}  @endif>{{ $golongan->golongan }}</option>
                        @endforeach
                    </select>
                    <label>TMT</label>
                    <input type="date" name="tmt" class="form-control" placeholder="Masukkan TMT" value="@if($data->tmt!='0000-00-00'){{ $data->tmt }}@endif" required="true">
                    <label>Masa Kerja</label>
                    <input type="text" name="masa_kerja" class="form-control" placeholder="Masukkan Masa Kerja" value="{{ $data->masa_kerja }}" required="true">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat" value="{{ $data->alamat }}" required="true">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="@if($data->tgl_lahir!='0000-00-00'){{ $data->tgl_lahir }}@endif" required="true">
                    <label>Status</label>
                    <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="radio" id="status_1" required="true" name="status" value="1" @if($data->status==1) {{ "checked='true'" }} @endif>
                        <label for="status_1">Aktif</label>
                      </div>
                      <div class="icheck-danger d-inline">
                        <input type="radio" id="status_0" required="true" name="status" value="0" @if($data->status==0) {{ "checked='true'" }} @endif>
                        <label for="status_0">Tidak Aktif</label>
                      </div>
                    </div>
                    <div class="form-group">
                        <label>Tanda Tangan</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="tanda_tangan" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">@if($data->tanda_tangan==null) Pilih Berkas @else {{ $data->tanda_tangan }} @endif</label>
                          </div>
                          
                        </div>
                      </div>

                    <button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>