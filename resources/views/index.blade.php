@extends('template') 
@section('title','Smart Office - Balittro')

@section('breadcrumbs')
	<div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"></li>
            <li class="breadcrumb-item active"><a href="#">{{ $title_layout }}</a></li>
        </ol>
    </div>
@endsection

@if($layout=='beranda')
	@section('content')
		@include('admin.beranda.index')
	@endsection

@elseif($layout=='pengajuan_perjalanan_dinas')
	@section('content')
		@include('admin.pengajuan_perjalanan_dinas.index')
	@endsection
@elseif($layout=='filter_cetak_sppd')
	@section('content')
		@include('admin.pengajuan_perjalanan_dinas.filter')
	@endsection
@elseif($layout=='cetak_sppd')
	@section('content')
		@include('admin.pengajuan_perjalanan_dinas.cetak')
	@endsection

@elseif($layout=='pinjam_pengemudi')
	@section('content')
		@include('admin.pinjam_pengemudi.index')
	@endsection

@elseif($layout=='cuti')
	@section('content')
		@include('admin.cuti.index')
	@endsection
@elseif($layout=='filter_cetak_cuti')
	@section('content')
		@include('admin.cuti.filter')
	@endsection
@elseif($layout=='cetak_cuti')
	@section('content')
		@include('admin.cuti.cetak')
	@endsection

@elseif($layout=='laporan_upg')
	@section('content')
		@include('admin.laporan_upg.index')
	@endsection
@elseif($layout=='filter_cetak_laporan_upg')
	@section('content')
		@include('admin.laporan_upg.filter')
	@endsection
@elseif($layout=='cetak_laporan_upg')
	@section('content')
		@include('admin.laporan_upg.cetak')
	@endsection

@elseif($layout=='laporan_spd')
	@section('content')
		@include('admin.laporan_spd.index')
	@endsection
@elseif($layout=='add_laporan_spd')
	@section('content')
		@include('admin.laporan_spd.add')
	@endsection
@elseif($layout=='edit_laporan_spd')
	@section('content')
		@include('admin.laporan_spd.edit')
	@endsection
@elseif($layout=='filter_cetak_laporan_spd')
	@section('content')
		@include('admin.laporan_spd.filter')
	@endsection
@elseif($layout=='cetak_laporan_spd')
	@section('content')
		@include('admin.laporan_spd.cetak')
	@endsection

@elseif($layout=='pinjam_kendaraan')
	@section('content')
		@include('admin.pinjam_kendaraan.index')
	@endsection
@elseif($layout=='acc_pinjam_kendaraan')
	@section('content')
		@include('admin.pinjam_kendaraan.add')
	@endsection
@elseif($layout=='edit_pinjam_kendaraan')
	@section('content')
		@include('admin.pinjam_kendaraan.edit')
	@endsection

@elseif($layout=='filter_cetak_pinjam_kendaraan')
	@section('content')
		@include('admin.pinjam_kendaraan.filter')
	@endsection
@elseif($layout=='cetak_pinjam_kendaraan')
	@section('content')
		@include('admin.pinjam_kendaraan.cetak')
	@endsection

@elseif($layout=='akun_pribadi')
	@section('content')
		@include('admin.akun_pribadi.index')
	@endsection

@elseif($layout=='filemanager')
	@section('content')
		@include('admin.filemanager.index')
	@endsection

@elseif($layout=='kwitansi_sppd')
	@section('content')
		@include('admin.kwitansi_sppd.index')
	@endsection
@elseif($layout=='add_kwitansi_sppd')
	@section('content')
		@include('admin.kwitansi_sppd.add')
	@endsection
@elseif($layout=='edit_kwitansi_sppd')
	@section('content')
		@include('admin.kwitansi_sppd.edit')
	@endsection
@elseif($layout=='filter_cetak_kwitansi_sppd')
	@section('content')
		@include('admin.kwitansi_sppd.filter')
	@endsection
@elseif($layout=='cetak_kwitansi_sppd')
	@section('content')
		@include('admin.kwitansi_sppd.cetak')
	@endsection



@elseif($layout=='beranda_super_admin')
	@section('content')
		@include('super_admin.beranda.index')
	@endsection

@elseif($layout=='pengguna_super_admin')
	@section('content')
		@include('super_admin.pengguna.index')
	@endsection
@elseif($layout=='add_pengguna_super_admin')
	@section('content')
		@include('super_admin.pengguna.add')
	@endsection
@elseif($layout=='edit_pengguna_super_admin')
	@section('content')
		@include('super_admin.pengguna.edit')
	@endsection

@elseif($layout=='akun_super_admin')
	@section('content')
		@include('super_admin.akun.index')
	@endsection
@elseif($layout=='add_akun_super_admin')
	@section('content')
		@include('super_admin.akun.add')
	@endsection
@elseif($layout=='edit_akun_super_admin')
	@section('content')
		@include('super_admin.akun.edit')
	@endsection

@elseif($layout=='pagu_anggaran_super_admin')
	@section('content')
		@include('super_admin.pagu_anggaran.index')
	@endsection
@elseif($layout=='add_pagu_anggaran_super_admin')
	@section('content')
		@include('super_admin.pagu_anggaran.add')
	@endsection
@elseif($layout=='edit_pagu_anggaran_super_admin')
	@section('content')
		@include('super_admin.pagu_anggaran.edit')
	@endsection

@elseif($layout=='potong_anggaran_super_admin')
	@section('content')
		@include('super_admin.potong_anggaran.index')
	@endsection
@elseif($layout=='add_potong_anggaran_super_admin')
	@section('content')
		@include('super_admin.potong_anggaran.add')
	@endsection

@elseif($layout=='tujuan_anggaran_super_admin')
	@section('content')
		@include('super_admin.tujuan_anggaran.index')
	@endsection
@elseif($layout=='add_tujuan_anggaran_super_admin')
	@section('content')
		@include('super_admin.tujuan_anggaran.add')
	@endsection
@elseif($layout=='edit_tujuan_anggaran_super_admin')
	@section('content')
		@include('super_admin.tujuan_anggaran.edit')
	@endsection

@elseif($layout=='jenis_anggaran_super_admin')
	@section('content')
		@include('super_admin.jenis_anggaran.index')
	@endsection
@elseif($layout=='add_jenis_anggaran_super_admin')
	@section('content')
		@include('super_admin.jenis_anggaran.add')
	@endsection
@elseif($layout=='edit_jenis_anggaran_super_admin')
	@section('content')
		@include('super_admin.jenis_anggaran.edit')
	@endsection

@elseif($layout=='biaya_anggaran_super_admin')
	@section('content')
		@include('super_admin.biaya_anggaran.index')
	@endsection
@elseif($layout=='add_biaya_anggaran_super_admin')
	@section('content')
		@include('super_admin.biaya_anggaran.add')
	@endsection
@elseif($layout=='edit_biaya_anggaran_super_admin')
	@section('content')
		@include('super_admin.biaya_anggaran.edit')
	@endsection

@elseif($layout=='jenis_golongan_super_admin')
	@section('content')
		@include('super_admin.jenis_golongan.index')
	@endsection
@elseif($layout=='add_jenis_golongan_super_admin')
	@section('content')
		@include('super_admin.jenis_golongan.add')
	@endsection
@elseif($layout=='edit_jenis_golongan_super_admin')
	@section('content')
		@include('super_admin.jenis_golongan.edit')
	@endsection

@elseif($layout=='jenis_gratifikasi_super_admin')
	@section('content')
		@include('super_admin.jenis_gratifikasi.index')
	@endsection
@elseif($layout=='add_jenis_gratifikasi_super_admin')
	@section('content')
		@include('super_admin.jenis_gratifikasi.add')
	@endsection
@elseif($layout=='edit_jenis_gratifikasi_super_admin')
	@section('content')
		@include('super_admin.jenis_gratifikasi.edit')
	@endsection

@elseif($layout=='jenis_jabatan_super_admin')
	@section('content')
		@include('super_admin.jenis_jabatan.index')
	@endsection
@elseif($layout=='add_jenis_jabatan_super_admin')
	@section('content')
		@include('super_admin.jenis_jabatan.add')
	@endsection
@elseif($layout=='edit_jenis_jabatan_super_admin')
	@section('content')
		@include('super_admin.jenis_jabatan.edit')
	@endsection

@elseif($layout=='jenis_pangkat_super_admin')
	@section('content')
		@include('super_admin.jenis_pangkat.index')
	@endsection
@elseif($layout=='add_jenis_pangkat_super_admin')
	@section('content')
		@include('super_admin.jenis_pangkat.add')
	@endsection
@elseif($layout=='edit_jenis_pangkat_super_admin')
	@section('content')
		@include('super_admin.jenis_pangkat.edit')
	@endsection

@elseif($layout=='pengemudi_super_admin')
	@section('content')
		@include('super_admin.pengemudi.index')
	@endsection
@elseif($layout=='add_pengemudi_super_admin')
	@section('content')
		@include('super_admin.pengemudi.add')
	@endsection
@elseif($layout=='edit_pengemudi_super_admin')
	@section('content')
		@include('super_admin.pengemudi.edit')
	@endsection

@elseif($layout=='cuti_super_admin')
	@section('content')
		@include('super_admin.cuti.index')
	@endsection
@elseif($layout=='edit_cuti_super_admin')
	@section('content')
		@include('super_admin.cuti.edit')
	@endsection

@elseif($layout=='akun_pribadi_')
	@section('content')
		@include('super_admin.akun_pribadi.index')
	@endsection

@else
	@section('content')
		@include('admin.404')
	@endsection
@endif