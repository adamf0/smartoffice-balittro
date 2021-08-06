<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center;"><b>LAPORAN UPG BALAI PENELITIAN TANAMAN REMPAH DAN OBAT</b></th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;"><b>PER {{ $bln }}</b></th>
        </tr>
        <tr>
            <th width="6" style="text-align: center;"><b>No</b></th>
            <th width="40" style="text-align: center;"><b>Nama</b></th>
            <th width="26" style="text-align: center;"><b>Jenis/bentuk gratifikasi</b></th>
            <th width="35" style="text-align: center;"><b>Lokasi</b></th>
            <th width="25" style="text-align: center;"><b>Tanggal Mulai</b></th>
            <th width="25" style="text-align: center;"><b>Tanggal Berakhir</b></th>
            <th width="25" style="text-align: center;"><b>Honor yang diterima (Rp)</b></th>
            <th width="30" style="text-align: center;"><b>Pemberi</b></th>
            <th width="35" style="text-align: center;"><b>Hubungan dengan pemberi gratifikasi</b></th>
        </tr>
    </thead>
    <tbody align="center">
    @php $no = 1 @endphp
    @foreach($datas as $data)
        <tr>
            <td style="text-align: center;">{{ $no++ }}</td>
            <th style="text-align: center;">{{ $data['pengguna'] }}</th>
            <th style="text-align: center;">{{ $data['gratifikasi'] }}</th>
            <th style="text-align: center;">{{ $data['lokasi'] }}</th>
            <th style="text-align: center;">{{ $data['tanggal_mulai'] }}</th>
            <th style="text-align: center;">{{ $data['tanggal_berakhir'] }}</th>
            <th style="text-align: center;">{{ $data['honor'] }}</th>
            <th style="text-align: center;">{{ $data['pemberi'] }}</th>
            <th style="text-align: center;">{{ $data['hubungan_gratifikasi'] }}</th>
        </tr>
    @endforeach
    </tbody>
</table>