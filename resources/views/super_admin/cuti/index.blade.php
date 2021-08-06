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
		          	<table id="table" class="table table-responsive table-normal">
		                <thead>
			                <tr>
			                  <th>#</th>
			                  <th>NIP</th>
			                  <th>Nama</th>
			                  <th>Total Cuti Tahun N</th>
			                  <th>Total Cuti Tahun N-1</th>
			                  <th>Total Cuti Tahun N-2</th>
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
			                	<td>{{ $data->cuti_n }} Hari</td>
			                	<td>{{ $data->cuti_n1 }} Hari</td>
			                	<td>{{ $data->cuti_n2 }} Hari</td>
			                	<td>
									@php $id = $data['id'] @endphp
				               		<a href='{{ url("/super_admin/cuti/edit/".$id) }}' class="btn btn-warning">Ubah</a>
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
