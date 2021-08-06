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
            		<a href='{{ url("/super_admin/biaya_anggaran/add") }}' class="btn btn-info">Tambah Data</a>
            	</div>
	            <div class="col-12">
		          	<table id="table" class="table table-responsive table-normal" >
		                <thead>
			                <tr>
			                  <th>#</th>
			                  <th>Nama Tujuan</th>
			                  <th width="30%">Nama Anggaran</th>
			                  <th width="25%">Biaya</th>
			                  <th>Aksi</th>
			                </tr>
		                </thead>
		                <tbody>
		                @php $i=0; @endphp
	                	@foreach($datas as $data => $items)	
		                	@php 
			                	$jml_anggaran = count($items); 
			                	$id_tujuan = $items[0]['id_tujuan'];
		                	@endphp
		                	<tr>
			                  	<td>{{ $i+1 }}</td>
			                  	<td>{{ $data }}</td>
			                  	<td width="30%">
			                  		<ul>
			                  			@for($x=0;$x<$jml_anggaran;$x++)
			                  				<li>{{ $items[$x]['nama_anggaran'] }}</li>
			                  			@endfor
			                  		</ul>
			                  	</td>
			                  	<td width="25%">
			                  		@for($x=0;$x<$jml_anggaran;$x++)
			                  			<li>{{ $items[$x]['biaya'] }}</li>
			                  		@endfor
			                  		
			                  	</td>
			                  	<td>
			                		<a href='{{ url("/super_admin/biaya_anggaran/delete/".$id_tujuan) }}' class="btn btn-danger">Hapus</a>
				               		<a href='{{ url("/super_admin/biaya_anggaran/edit/".$id_tujuan) }}' class="btn btn-warning">Ubah</a>
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
