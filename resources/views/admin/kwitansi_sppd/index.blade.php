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
			    @if(Session::get('role')==6)
			    <a href='{{ url("/admin/kwitansi_sppd/add") }}' class="btn btn-info">Tambah Data</a>
			    @elseif(Session::get('role')==7)
			    <a href="{{ url('/admin/cetak/surat_quitansi') }}" class="btn btn-primary">Simpan Laporan SPPD Digital</a><br><br>
			    @endif
			</div>
			<div class="col-12">
				  	<table id="table" class="table table-responsive table-normal">
				        <thead>
				            <tr>
				                <th>#</th>
				                <th>Nomor SPPD</th>
				                <th>Tanggal</th>
				                <th>Tujuan Perjalanan Dinas</th>
				                <th>Maksud Perjalanan</th>
				                <th>Pagu Anggaran</th>
				                <th>Biaya Telah Digunakan</th>
				                <th>Biaya Akan Digunakan</th>
				                <th>Perincian Biaya</th>
				                <th>Jumlah</th>
				                <th>Total</th>
				                <th>Status</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				           	@php $i=1; @endphp
				           	@foreach($datas as $data)
				           		<tr>
				           			<td>{{ $i }}</td>
					                <td>{{ $data['nomor_laporan'] }}</td>
					                <td>{{ $data['tanggal'] }}</td>
					                <td>{{ $data['tujuan'] }}</td>
					                <td>{{ $data['maksud'] }}</td>
					                <td>Rp.{{ number_format($data['pagu_anggaran'],0,'','.') }}</td>
					                <td>Rp.{{ number_format($data['biaya_telah_digunakan'],0,'','.') }}</td>
					                <td>Rp.{{ number_format($data['biaya_akan_digunakan'],0,'','.') }}</td>
					                <td>
					                	<ul>
					                		<li>Transport</li>
					                		<li>Penginapan dan Makan</li>
					                		<li>Angkutan Setempat/Biaya Rill</li>
					                		<li>Uang Saku</li>
					                	</ul>
					            	</td>
					                <td>
					                	<ul>
					                		<li>Rp.{{ number_format($data['transport'],0,'','.') }}</li>
					                		<li>Rp.{{ number_format($data['penginapan_makan'],0,'','.') }}</li>
					                		<li>Rp.{{ number_format($data['biaya_rill'],0,'','.') }}</li>
					                		<li>Rp.{{ number_format($data['uang_saku'],0,'','.') }}</li>
					                	</ul>
					                </td>
					                <td>Rp.{{ number_format($data['transport'] + $data['penginapan_makan'] + $data['biaya_rill'] + $data['uang_saku'],0,'','.') }}</td>
					                <td>
					               		@if($data['status']==-1)
					               			<label class="badge badge-danger">Laporan Ditolak</label>
					               		@elseif($data['status']==0)
					               			<label class="badge badge-warning">Menunggu Diterima</label>
					               		@elseif($data['status']==1)
					               			<label class="badge badge-success">Laporan Diterima</label>			        
					               		@else
					               			<label class="badge badge-primary">Belum Lengkap</label>
					               		@endif
					               	</td>
					             	<td>
										@php $id = $data['id']; $id_sppd = $data['id_sppd']; @endphp

										@if(Session::get('role')==6)
											@if($data['status'] != 1 || $data['status'] != -2)
							           			<a href='{{ url("/admin/kwitansi_sppd/delete/".$id) }}' class="btn btn-danger btn-block">Hapus</a>
							           			<a href='{{ url("/admin/kwitansi_sppd/edit/".$id) }}' class="btn btn-warning btn-block mt-2">Ubah</a>
							           		@endif
							           	@elseif(Session::get('role')==7)
							           		<a href='{{ url("/admin/kwitansi_sppd/reject/".$id) }}' class="btn btn-danger btn-block">Tolak Laporan</a>
			               					<a href='{{ url("/admin/kwitansi_sppd/acc/".$id) }}' class="btn btn-success btn-block mt-2">ACC Laporan</a>
			               					<a href='{{ url("/admin/kwitansi_sppd/invalid/".$id) }}' class="btn btn-info btn-block mt-2">Laporan Tidak Lengkap</a>
							           	@endif
							           	@if($data['status']==1)
			               					<a href="{{ url('/admin/download/surat_quitansi/').'/'.$id_sppd }}" class="btn btn-secondary btn-block mt-2" target="_blank">Cetak Kwitansi SPPD</a>	
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