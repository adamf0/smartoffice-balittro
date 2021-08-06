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
            		<a href='{{ url("/super_admin/pagu_anggaran/add") }}' class="btn btn-info">Tambah Data</a>
            	</div>
	            <div class="col-12">
		          	<table id="table" class="table table-responsive table-normal">
		                <thead>
			                <tr>
			                  <th>#</th>
			                  <th>Kode/MAK</th>
			                  <th>Nama Kegiatan</th>
			                  <th>Penanggung Jawab</th>
			                  <th>Total Pagu Anggaran</th>
			                  <th>Sisa Pagu Anggaran</th>
			                  <th>Tanggal</th>
			                  <th>Aksi</th>
			                </tr>
		                </thead>
		                <tbody>
	                	@php $i=1; @endphp
	                	@foreach($datas as $data)
		                	<tr>
		                		<td>{{ $i }}</td>
			                	<td>{{ $data['kode'] }}</td>
			                	<td>{{ $data['nama_kegiatan'] }}</td>
			                	<td>{{ $data['penanggung_jawab'] }}</td>
			                	<td>{{ "Rp " . number_format($data['total_biaya'],0,'','.') }}</td>
			                	<td>{{ "Rp " . number_format($data['sisa_biaya'],0,'','.') }}</td>
			                	<td>{{ $data['tanggal'] }}</td>
			                	<td>
									@php $id = $data['id'] @endphp
				               		<a href='{{ url("/super_admin/pagu_anggaran/delete/".$id) }}' class="btn btn-danger">Hapus</a>
				               		<a href='{{ url("/super_admin/pagu_anggaran/edit/".$id) }}' class="btn btn-warning">Ubah</a>
				               		<a href='{{ url("/super_admin/potong_anggaran/".$id) }}' class="btn btn-primary">Potong Anggaran</a>
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
