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
            	@if(Session::get('role')==1)
            	<a href="{{ url('/admin/cetak/surat_cuti') }}" class="btn btn-primary">Simpan Laporan Cuti Digital</a><br><br>
	            @endif
	            <table id="table" class="table table-responsive table-normal">
	                <thead>
		                <tr>
		                  <th>#</th>
		                  <th>Nomor Cuti</th>
		                  <th>Pengguna</th>
		                  <th>Jenis Cuti</th>
		                  <th>Alasan</th>
		                  <th>Tanggal</th>
		                  <th>Lama Cuti</th>
		                  <th>Alamat Cuti</th>
		                  <th>Telp</th>
		                  <th>Status</th>
		                  <th>Catatan Admin 1</th>
		                  <th>Catatan Admin 2</th>
		                  <th>Aksi</th>
		                </tr>
	                </thead>
	                <tbody>
                	@php $i=1; @endphp
                	@foreach($datas as $data)
	                	<tr>
	                		<td>{{ $i }}</td>
	                		<td>{{ $data['nomor_cuti'] }}</td>
	                		<td>
	                			@if($data['pengguna']==null) 
	                				<label class="badge badge-danger">N/a</label>
	                			@else
	                				{{ $data['pengguna']['nama'] }}
	                			@endif
	                		</td>
		                	<td>
		                		@if($data['jenis_cuti']==null) 
		                			<label class="badge badge-danger">N/a</label> 
		                		@else
		                			{{ $data['jenis_cuti']['nama'] }}
		                		@endif
		                	</td>
		                	<td>{{ $data['alasan'] }}</td>
		                	<td>{{ $data['tanggal'] }}</td>
		                	<td>{{ $data['lama'] }} Hari</td>
		                	<td>{{ $data['alamat_cuti'] }}</td>
		                	<td>{{ $data['telp'] }}</td>
		                	<td>
		                		@if($data['status_acc1']==0)
		               			<label class="badge badge-warning">
		               				Menunggu Admin 1
		               			@elseif($data['status_acc1']==1)
		               			<label class="badge badge-success">
		               				Disetujui Admin 1
		               			@elseif($data['status_acc1']==-1)
		               			<label class="badge badge-primary">
		               				Perubahan Admin 1
		               			@elseif($data['status_acc1']==-2)
		               			<label class="badge badge-primary">
		               				Ditangguhkan Admin 1
		               			@else
		               			<label class="badge badge-danger">
		               				Tidak Disetujui Admin 1
		               			@endif
		               			</label>

		               			@if($data['status_acc2']==0)
		               			<label class="badge badge-warning">
		               				Menunggu Admin 2
		               			@elseif($data['status_acc2']==1)
		               			<label class="badge badge-success">
		               				Disetujui Admin 2
		               			@elseif($data['status_acc2']==-1)
		               			<label class="badge badge-primary">
		               				Perubahan Admin 2
		               			@elseif($data['status_acc2']==-2)
		               			<label class="badge badge-primary">
		               				Ditangguhkan Admin 2
		               			@else
		               			<label class="badge badge-danger">
		               				Tidak Disetujui Admin 2
		               			@endif
		               			</label>
		                	</td>
		                	<td>
		                		@if($data['catatan_acc1']==null)
		                			<label class="badge badge-danger">N/a</label>
		                		@else
		                			{{ $data['catatan_acc1'] }}
		                		@endif
		                	</td>
		                	<td>
		                		@if($data['catatan_acc2']==null)
		                			<label class="badge badge-danger">N/a</label>
		                		@else
		                			{{ $data['catatan_acc2'] }}
		                		@endif
		                	</td>
		                	<td>
								@php $id = $data['id'] @endphp
								<a href='{{ url("/admin/cuti/1/$id") }}' class="btn btn-success btn-block">Disetujui</a><br><br>
			               		<a href='#' data-status='-1' data-id="{{ $id }}" class="btn btn-info btn-block dialogs" data-toggle="modal" data-target=".modal">Perubahan</a><br><br>
			               		<a href='#' data-status='-2' data-id="{{ $id }}" class="btn btn-info btn-block dialogs" data-toggle="modal" data-target=".modal">Ditangguhkan</a><br><br>
			               		<a href='#' data-status='-3' data-id="{{ $id }}" class="btn btn-danger btn-block dialogs" data-toggle="modal" data-target=".modal">Tidak Disetujui</a><br><br>


            					@if(Session::get('role')==1)
				               		@if($data['status_acc1']==1 && $data['status_acc2']==1)
				               		<a href='{{ url("/admin/download/surat_cuti/".$id) }}' class="btn btn-secondary btn-block" target="_blank">Cetak Laporan Cuti</a>
				               		@endif
				               	@endif
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

<div class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal Header</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="/admin/cuti" method="post" id="form">
	        <div class="modal-body">
	          	{{ csrf_field() }}
	          	<input type="hidden" name="id" id="edt_id">
	          	<input type="hidden" name="status" id="edt_status">

	          	<label>Alasan</label>
	          	<input type="text" name="alasan" class="form-control">
	        </div>
	        <div class="modal-footer">
	          <button type="submit" class="btn btn-success">Simpan</button>
	        </div>
        </form>
      </div>
      
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
	    $(".dialogs").on('click', function() {
	    	document.getElementById("edt_id").value = $(this).data("id");
	    	document.getElementById("edt_status").value = $(this).data("status");
		});
	});
</script>