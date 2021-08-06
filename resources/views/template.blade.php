<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ url('storage/app/public/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ url('storage/app/public/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ url('storage/app/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="{{ url('storage/app/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  
  <script src="{{ url('storage/app/public/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('storage/app/public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <link rel="stylesheet" href="{{ url('storage/app/public/plugins/bootstrap-chosen/bootstrap-chosen.css') }}">
  <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script> -->
  <link rel="stylesheet" type="text/css" href="{{ url('storage/app/public/packages/barryvdh/elfinder/css/elfinder.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('storage/app/public/packages/barryvdh/elfinder/css/theme.css') }}">
  <script src="{{ url('storage/app/public/packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script>

  <style type="text/css">
    .chosen-container {
      width: 100% !important;
    }
    .table-normal{
      white-space : nowrap;
      text-align: center;
    }
    .disabled {
      cursor: not-allowed !important;
      pointer-events: none !important;
    }
  </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-3">
            <a href="{{ url('/logout') }}"><i class="fa fa-door-open text-danger"></i></a>
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="@if(Session::get('foto')==null) {{ url('storage/app/public/dist/img/user2-160x160.jpg') }} @else {{ url('/public/user-image/'.Session::get('foto')) }} @endif" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              {{ Session::get('nama') }}</a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @php
              $role = Session::get('role');
            @endphp

            @if($role == 4)
              <li class="nav-item">
                <a href="{{ url('/super_admin/beranda') }}" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Beranda
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/pengguna') }}" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Pengguna
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/akun') }}" class="nav-link">
                  <i class="nav-icon fas fa-id-card"></i>
                  <p>
                    Akun
                  </p>
                </a>
              </li>
              
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-file"></i>
                  <p>
                    Anggaran
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/super_admin/pagu_anggaran') }}" class="nav-link" style="padding-left: 10%">
                      <i class="fas fa-book nav-icon"></i>
                      <p>Pagu Anggaran</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/super_admin/jenis_anggaran') }}" class="nav-link" style="padding-left: 10%">
                      <i class="fas fa-filter nav-icon"></i>
                      <p>Jenis Anggaran</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/super_admin/tujuan_anggaran') }}" class="nav-link" style="padding-left: 10%">
                      <i class="fas fa-map-signs nav-icon"></i>
                      <p>Tujuan Anggaran</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/super_admin/biaya_anggaran') }}" class="nav-link" style="padding-left: 10%">
                      <i class="fas fa-money-bill nav-icon"></i>
                      <p>Biaya Anggaran</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="{{ url('/super_admin/jenis_golongan') }}" class="nav-link">
                  <i class="nav-icon fas fa-project-diagram"></i>
                  <p>
                    Golongan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/jenis_gratifikasi') }}" class="nav-link">
                  <i class="nav-icon fas fa-handshake"></i>
                  <p>
                    Jenis Gratifikasi
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/jenis_jabatan') }}" class="nav-link">
                  <i class="nav-icon fas fa-sitemap"></i>
                  <p>
                    Jabatan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/jenis_pangkat') }}" class="nav-link">
                  <i class="nav-icon fas fa-sort-amount-up-alt"></i>
                  <p>
                    Pangkat
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/pengemudi') }}" class="nav-link">
                  <i class="nav-icon fas fa-car"></i>
                  <p>
                    Pengemudi
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/cuti') }}" class="nav-link">
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>
                    Cuti
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/super_admin/akun_pribadi') }}" class="nav-link">
                  <i class="nav-icon fas fa-id-card"></i>
                  <p>
                    Akun Pribadi
                  </p>
                </a>
              </li>              
            @else
              <li class="nav-item">
                <a href="{{ url('/admin/beranda') }}" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Beranda
                  </p>
                </a>
              </li>
              @if($role != null)
                  @if($role==1)
                  <li class="nav-item">
                    <a href="{{ url('/admin/pengajuan_perjalanan_dinas') }}" class="nav-link">
                      <i class="nav-icon fas fa-map-marked-alt"></i>
                      <p>
                        Pengajuan Perjalanan Dinas
                      </p>
                    </a>
                  </li>
                  @endif

                  @if($role==8)
                  <li class="nav-item">
                    <a href="{{ url('/admin/pinjam_kendaraan') }}" class="nav-link">
                      <i class="nav-icon fas fa-car"></i>
                      <p>
                        Pinjam Kendaraan
                      </p>
                    </a>
                  </li>
                  @endif

                  @if($role==1 || $role==8)
                  <li class="nav-item">
                    <a href="{{ url('/admin/cuti') }}" class="nav-link">
                      <i class="nav-icon fas fa-calendar-alt"></i>
                      <p>
                        Cuti
                      </p>
                    </a>
                  </li>
                  @endif
                  
                  @if($role==9)
                  <li class="nav-item">
                    <a href="{{ url('/admin/laporan_upg') }}" class="nav-link">
                      <i class="nav-icon fas fa-folder-open"></i>
                      <p>
                        UPG
                      </p>
                    </a>
                  </li>
                  @endif

                  @if($role==6 || $role==7)
                  <li class="nav-item">
                    <a href="{{ url('/admin/kwitansi_sppd') }}" class="nav-link">
                      <i class="nav-icon fas fa-folder-open"></i>
                      <p>
                        Kwitansi SPPD
                      </p>
                    </a>
                  </li>
                  @endif

                  @if($role==5)
                  <li class="nav-item">
                    <a href="{{ url('/admin/laporan_spd') }}" class="nav-link">
                      <i class="nav-icon fas fa-folder-open"></i>
                      <p>
                        Laporan SPD
                      </p>
                    </a>
                  </li>
                  @endif

                  <li class="nav-item">
                    <a href="{{ url('/admin/akun_pribadi') }}" class="nav-link">
                      <i class="nav-icon fas fa-id-card"></i>
                      <p>
                        Akun Pribadi
                      </p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ url('/admin/filemanager') }}" class="nav-link">
                      <i class="nav-icon fas fa-id-card"></i>
                      <p>
                        File Manager
                      </p>
                    </a>
                  </li>
              @endif
            @endif

          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
        
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">{{ $title_layout }}</h1>
            </div>
        	
          	@section('breadcrumbs')
          	@show

          </div>
        </div>
      </div>  

      <section class="content">
        <div class="container-fluid">
            @section('content')
            @show
        </div>
      </section>

    </div>
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.2-pre
      </div>
    </footer>
  </div>

</body>
  <!-- <script src="{{ url('storage/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('storage/plugins/jquery-ui/jquery-ui.min.js') }}"></script> -->
  <script src="{{ url('storage/app/public/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ url('storage/app/public/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ url('storage/app/public/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ url('storage/app/public/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="{{ url('storage/app/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('storage/app/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ url('storage/app/public/dist/js/adminlte.js') }}"></script>
  <script src="{{ url('storage/app/public/dist/js/demo.js') }}"></script>
  <script src="{{ url('storage/app/public/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

  <script type="text/javascript">  
    $(function () {
      var table = $('#table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 10
      });

      $('.datemask').inputmask('yyyy-mm', { 'placeholder': 'yyyy-mm' });
      $('.datemaskv2').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });
      bsCustomFileInput.init();
      $('.chosen-select').chosen();

      $(document).on('click', '.btn-add', function(e){
            e.preventDefault();
            var controlForm = $('form .controls:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            newEntry.find('select').val('');

            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="fa fa-minus"></span>');
        }).on('click', '.btn-remove', function(e){
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
      });

      setTimeout(function() {
          $(".notif").alert('close');
      }, 3000);

      $('#elfinder').elfinder({
            customData: { 
              _token: '<?= csrf_token() ?>'
            },
            url : '<?= route("elfinder.connector") ?>',  // connector URL
            soundPath: '{{ url("storage/app/public/packages/barryvdh/elfinder/sounds") }}'
        });
    });
  </script>
</html>