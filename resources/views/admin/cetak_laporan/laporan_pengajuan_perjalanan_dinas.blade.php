<style type="text/css">
  .table td{
    border-top: 0px;
    padding: 0.5em
  }  
</style>     
        <center>
            <b style="font-size: 14px">
              BADAN PENELITIAN DAN PENGEMBANGAN PERTANIAN<br>
              PUSAT PENELITIAN DAN PENGEMBANGAN PERKEBBUNAN<br>
              BALAI PENELITIAN TANAMAN REMPAH DAN OBAT<br>
              <br>
              PENGAJUAN PERJALANAN DINAS
              <br>
            </b>
        </center>
        <br>
        <table class="table" style="font-size:10px">
            <tr>
                <td width="30%">Yth.</td>
                <td width="70%">: Kuasa Pengguna Anggaran</td>
            </tr>
            <tr>
                <td width="30%">Dari Penanggung Jawab Kegiatan</td>
                <td width="70%">: {{ $data['penanggung_jawab'] }}</td>
            </tr>
            <tr>
                <td width="30%">Judul Kegiatan</td>
                <td width="70%">: {{ $data['judul'] }}</td>
            </tr>
            <tr>
                <td width="30%">Menugaskan</td>
                <td width="70%">: </td>
            </tr>
        </table>
        <table class="table table-bordered" style="font-size:10px;margin-top: -20px">
            <tr>
                <td style="width:30%">Nama Pegawai</td>
                <td style="width:70%">
                  <ol>
                    @foreach($data['menugaskan'] as $menugaskan)
                        <li>{{ $menugaskan }}</li>
                    @endforeach
                  </ol>
                </td>
            </tr>
            <tr>
                <td style="width:30%">Tujuan</td>
                <td style="width:70%">: {{ $data['tujuan'] }}</td>
            </tr>
            <tr>
                <td style="width:30%">Maksud Perjalanan</td>
                <td style="width:70%">: {{ $data['maksud_perjalanan'] }}</td>
            </tr>
            <tr>
                <td style="width:30%">Tanggal/Lama Perjalanan</td>
                <td style="width:70%">: {{ $data['tanggal_berangkat'] }} sd {{ $data['tanggal_kembali'] }}</td>
            </tr>
            <tr>
                <td style="width:30%">Kegiatan</td>
                <td style="width:70%">: {{ $data['kegiatan'] }}</td>
            </tr>
            <tr>
                <td style="width:30%">Kendaraan yang digunakan</td>
                <td style="width:70%">: 
                    @if($data['jenis_kendaraan'] != 1)
                        <strike>Umum</strike>
                    @else
                        Umum
                    @endif
                    / 
                    @if($data['jenis_kendaraan'] != 0)
                        <strike>Dinas</strike>
                    @else
                        Dinas
                    @endif
                </td>
            </tr>
        </table>
        <table class="table" style="font-size:10px">
            <tr>
                <td class="text-center">Mengetahui/Menyetujui:<br>Kuasa Pengguna Anggaran</td>
                <td class="text-center">Penanggungjawab:<br>RODHP/ROPP/RDHP/RPTP</td>
            </tr>
            <tr>
                <td class="text-center">
                    <br>
                    <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin']['tanda_tangan']) }}" width="100px" height="50px">
                    <br>
                    {{ $data['tanda_tangan']['admin']['nama'] }}<br>
                    NIP:{{ $data['tanda_tangan']['admin']['nip'] }}
                </td>
                <td class="text-center">
                    <br>
                    <img src="{{ public_path('storage/'.$data['tanda_tangan']['pengaju']['tanda_tangan']) }}" width="100px" height="50px">
                    <br>
                    {{ $data['tanda_tangan']['pengaju']['nama'] }}<br>
                    NIP:{{ $data['tanda_tangan']['pengaju']['nip'] }}
                </td>
            </tr>
        </table>
        <table class="table table-bordered" style="font-size:10px;margin-top: -20px">
            <tr>
                <td style="width: 40%">1. Pagu Anggaran</td>
                <td style="width: 100% !important">Rp. {{ $data['pagu_anggaran'] }}</td>
            </tr>
            <tr>
                <td>2. Biaya yang telah digunakan</td>
                <td style="width: 100% !important">Rp. {{ $data['biaya_telah_digunakan'] }}</td>
            </tr>
            <tr>
                <td>3. Biaya yang akan digunakan</td>
                <td style="width: 100% !important">Rp. {{ $data['biaya_akan_digunakan'] }}</td>
            </tr>
            <tr>
                <td>4. Sisa Anggaran</td>
                <td style="width: 100% !important">Rp. {{ $data['sisa_anggaran'] }}</td>
            </tr>
        </table>