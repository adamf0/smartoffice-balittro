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
            <div class="card-header ui-sortable-handle bg-primary" style="cursor: move;">
                <h3 class="card-title"> </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
            	<div class="col-12">
            		<a href='{{ url("/super_admin/pengguna/add") }}' class="btn btn-info">Tambah Data</a>
            	</div>
	            <div class="col-12">
		          	<table id="table" class="table table-responsive table-normal">
		                <thead>
			                <tr>
			                  <th>#</th>
			                  <th>NIP</th>
			                  <th>Nama</th>
			                  <th>Agama</th>
			                  <th>Jenjang Pendidikan</th>
			                  <th>Nama Sekolah</th>
			                  <th>Tahun Lulus</th>
			                  <th>Jabatan</th>
			                  <th>Pangkat</th>
			                  <th>Golongan</th>
			                  <th>TMT</th>
			                  <th>Masa Kerja</th>
			                  <th>Alamat</th>
			                  <th>Tanggal Lahir</th>
			                  <th>Status</th>
			                  <th>Aksi</th>
			                </tr>
		                </thead>
		                <tbody>
	                	@php $i=1; @endphp
	                	@foreach($datas as $data)
		                	<tr>
		                		<td>{{ $i }}</td>
			                	<td>{{ $data->nip }}</td>
			                	<td>{{ $data->nama }}</td>
			                	<td>{{ $data->agama->agama }}</td>
			                	<td>{{ $data->jenjang_pendidikan->jenjang_pendidikan }}</td>
			                	<td>{{ $data->nama_sekolah }}</td>
			                	<td>{{ $data->tahun_lulus }}</td>
			                	<td>{{ $data->jabatan->jabatan }}</td>
			                	<td>{{ $data->pangkat->pangkat }}</td>
			                	<td>{{ $data->golongan->golongan }}</td>
			                	<td>{{ \Carbon\Carbon::parse($data->tmt)->formatLocalized("%A, %d %B %Y") }}</td>
			                	<td>{{ $data->masa_kerja }} Hari</td>
			                	<td>{{ $data->alamat }}</td>
			                	<td>
			                		@if($data->tgl_lahir=='0000-00-00')
			                			<label class="badge badge-danger">N/a</label>
			                		@else
			                			{{ \Carbon\Carbon::parse($data->tgl_lahir)->formatLocalized("%A, %d %B %Y") }}
			                		@endif
			                	</td>
			                	<td>
			                		@if($data->status==1)
			                		<span class="badge badge-success">Aktif</span>
			                		@else
			                		<span class="badge badge-danger">Tidak Aktif</span>
			                		@endif 
			                		
			                		@if($data->id_user==null)
			                		<span class="badge badge-danger">Belum Terhubung Akun</span>
			                		@else
			                		<span class="badge badge-primary">Sudah Terhubung Akun</span>
			                		@endif

			                		@if($data->tanda_tangan==null)
			                		<span class="badge badge-danger">Tanda Tangan Belum Ada</span>
			                		@else
			                		<span class="badge badge-primary">Tanda Tangan Ada</span>
			                		@endif 
			                	
			                	</td>
			                	<td>
									@php $id = $data['id'] @endphp
				               		<a href='{{ url("/super_admin/pengguna/delete/".$id) }}' class="btn btn-danger">Hapus</a>
				               		<a href='{{ url("/super_admin/pengguna/edit/".$id) }}' class="btn btn-warning">Ubah</a>
				               	</td>
				            </tr>
		               		@php $i++ @endphp
		               	@endforeach
		                </tbody>
		            </table>
	            </div>
            </div>
        </div>
    </div>
</div>
