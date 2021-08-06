<style type="text/css">
  .table td{
    border-top: 0px;
  }  
</style>     
        <center>
            <b>
              Laporan UPG BALAI PERTANIAN REMPAH DAN OBAT <br>
              PER {{ $bulan }}
              <br>
            </b>
        </center>
        <br>
        <table class="table" style="font-size:10px;text-align: center;" border="1">
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Jenis/bentuk gratifikasi</td>
                <td>Lokasi</td>
                <td>Tanggal Mulai</td>
                <td>Tanggal Berakhhiir</td>
                <td>Honor yang diterima (Rp)</td>
                <td>Pemberi</td>
                <td>Hubungan Pemberi</td>
            </tr>
            @php $i = 1;@endphp
            @foreach($datas as $data)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $data['nama'] }}</td>
                <td>{{ $data['gratifikasi'] }}</td>
                <td>{{ $data['lokasi'] }}</td>
                <td>{{ $data['tanggal_mulai'] }}</td>
                <td>{{ $data['tanggal_berakhir'] }}</td>
                <td>{{ $data['honor'] }}</td>
                <td>{{ $data['pemberi'] }}</td>
                <td>{{ $data['hubungan'] }}</td>
            </tr>
            @php $i++ @endphp
            @endforeach
        </table>