
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Balai Penelitian Tanaman Rempah dan Obat | Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ url('storage/app/public/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ url('storage/app/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('storage/app/public/dist/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
      <div class="login-logo" style="font-size: 1.6rem !important;">
        <img src="{{ Storage::url('app/public/logo.png') }}"/ width="100px" height="100px" class="img-responsive"><br>
        <b>Balai Penelitian Tanaman Rempah dan Obat</b>
      </div>

      <div class="card">
          <div class="row">
              @if (Session::has('type_msg'))
                  <div class="col-12">
                      @if(Session::get('type_msg')==0)
                      <div class="alert alert-danger alert-block notif">
                      @elseif(Session::get('type_msg')==1)
                      <div class="alert alert-success alert-block notif">
                      @endif
                          <strong>{{ Session::get('msg') }}</strong>
                      </div>
                  </div>
              @endif
          </div>
          <div class="card-body login-card-body">
              <p class="login-box-msg">Login untuk memulai pekerjaan</p>

              <form action="{{ url('login') }}" method="post">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="username" placeholder="Username">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="password" placeholder="Password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                  </div>
                </div>
              </form>
          </div>
      </div>
  </div>
<script src="{{ url('storage/app/public/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ url('storage/app/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('storage/app/public/dist/js/adminlte.min.js') }}"></script>
<script type="text/javascript">  
    $(function () {
      setTimeout(function() {
          $(".notif").alert('close');
      }, 3000);
    });
  </script>
</body>
</html>
