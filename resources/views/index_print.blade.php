@extends('template_print') 
@section('title','apps')

@if($layout=='cetak_pengajuan_perjalanan_dinas')
	@section('content')
		@include('admin.cetak_laporan.laporan_pengajuan_perjalanan_dinas')
	@endsection

@elseif($layout=='cetak_surat_tugas')
	@section('content')
		@include('admin.cetak_laporan.laporan_surat_tugas')
	@endsection

@elseif($layout=='cetak_pinjam_kendaraan')
	@section('content')
		@include('admin.cetak_laporan.laporan_surat_pinjam_kendaraan')
	@endsection

@elseif($layout=='cetak_surat_spd')
	@section('content')
		@include('admin.cetak_laporan.laporan_surat_spd')
	@endsection

@elseif($layout=='cetak_kwitansi_sppd')
	@section('content')
		@include('admin.cetak_laporan.laporan_surat_quitansi')
	@endsection

@elseif($layout=='cetak_laporan_upg')
	@section('content')
		@include('admin.cetak_laporan.laporan_upg')
	@endsection

@elseif($layout=='cetak_laporan_cuti')
	@section('content')
		@include('admin.cetak_laporan.laporan_cuti')
	@endsection

@endif