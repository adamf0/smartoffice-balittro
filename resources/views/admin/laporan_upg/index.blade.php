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
            	<a href="{{ url('/admin/cetak/laporan_upg') }}" class="btn btn-primary">Simpan Laporan UPG Digital</a><br><br>
	            <table id="table" class="table table-responsive table-normal">
	                <thead>
		                <tr>
		                  <th>#</th>
		                  <th>Nomor Laporan</th>
		                  <th>Pengguna</th>
		                  <th>Lokasi</th>
		                  <th>Tanggal Mulai</th>
		                  <th>Tanggal Berakhir</th>
		                  <th>Honor</th>
		                  <th>Pemberi</th>
		                  <th>Gratifikasi</th>
		                  <th>Keterangan</th>
		                  <th>Hubungan Gratifikasi</th>
		                  <th>Status</th>
		                  <th>Aksi</th>
		                </tr>
	                </thead>
	                <tbody>
                	@php $i=1; @endphp
                	@foreach($datas as $data)
                		@php $keterangan = null; @endphp
	                	<tr>
	                		<td>{{ $i }}</td>
	                		<td>
	                			@if($data['nomor_laporan']==null)
	                				<label class="badge badge-danger">N/a</label>
	                			@else
	                				{{ $data['nomor_laporan'] }}
	                			@endif
	                		</td>
	                		<td>
	                			@if($data['pengguna']==null)
	                				<label class="badge badge-danger">N/a</label>
	                			@else
	                				{{ $data['pengguna']['nama'] }}
	                			@endif
	                		</td>
		                	<td>{{ $data['lokasi'] }}</td>
		                	<td>{{ $data['tanggal_mulai'] }}</td>
		                	<td>{{ $data['tanggal_berakhir'] }}</td>
		                	<td>{{ $data['honor'] }}</td>
		                	<td>{{ $data['pemberi'] }}</td>
		                	<td>
		                		@if(count($data['gratifikasi'])>0)
		                		<ul>		                		
			                		@foreach($data['gratifikasi'] as $item)
			                			<li>
				                			@if(strtolower($item['nama'])=="honor")
				                			<label class="badge badge-primary">
				                			@elseif(strtolower($item['nama'])=="dinas")
				                			<label class="badge badge-success">
				                			@else
				                			<label class="badge badge-secondary">
				                				@php $keterangan = $item['keterangan']; @endphp
				                			@endif
				                			{{ $item['nama'] }}
				                			</label>
			                			</li>
			                		@endforeach
		                		</ul>
		                		@else
		                			N/a
		                		@endif
		                	</td>
		                	<td>
		                		@if($keterangan==null)
		               			<label class="badge badge-danger">
		               				N/a
		               			</label>
		               			@else
		               				{{ $keterangan }}
		               			@endif
		                	</td>
		                	<td>{{ $data['hubungan_gratifikasi'] }}</td>
		                	<td>
		                		@if($data['status']==-1)
		               			<label class="badge badge-danger">
		               				Tolak Laporan UPG
		               			@elseif($data['status']==0)
		               			<label class="badge badge-warning">
		               				Menunggu Laporan UPG
		               			@elseif($data['status']==1)
		               			<label class="badge badge-success">
		               				ACC Laporan UPG
		               			@else
		               			<label class="badge badge-primary">
		               				Belum Lengkap Laporan UPG
		               			@endif
		               			</label>
		                	</td>
		                	<td>
								@php $id = $data['id'] @endphp
			               		<a href='{{ url("/admin/laporan_upg/reject/".$id) }}' class="btn btn-danger btn-block">Tolak Laporan</a><br><br>
			               		<a href='{{ url("/admin/laporan_upg/acc/".$id) }}' class="btn btn-success btn-block">ACC Laporan</a><br><br>
			               		<a href='{{ url("/admin/laporan_upg/invalid/".$id) }}' class="btn btn-info btn-block">Laporan Tidak Lengkap</a>
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
