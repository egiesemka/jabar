<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link href="{{ asset('admin_lte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('admin_lte/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Ionicons -->
    <link href="{{ asset('admin_lte/bower_components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset('admin_lte/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div >
        <div class="wrapper">
                <!-- Main content -->
                <section class="invoice">
                  <!-- title row -->
                  <div class="row">
                    <div class="col-xs-12">
                      <h2 class="page-header">
                        <i class="fa fa-globe"></i> Perusahaan X
                        {{-- <small class="pull-right"></small> --}}
                      </h2>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- info row -->
                  <div class="row invoice-info">
                    <div class="col-sm-12 invoice-col">
                      <h3 style="text-align:center">SURAT KETERANGAN CUTI</h3>
                      <br/><br/>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
              
                  <!-- Table row -->
                  <div class="row">
                    <div class="col-xs-12 table-responsive">
                      <table class="table table-striped">
                        <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Jabatan</th>
                          <th>Tanggal pengajuan dibuat</th>
                          <th>Tanggal penerimaan pengajuan</th>
                          <th>Tanggal Cuti</th>
                          <th>Durasi Cuti</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>{{$datas->pengaju}}</td>
                          <td>{{$datas->nama_jabatan}}</td>
                          <td>{{$datas->created_at }}</td>
                          <td>{{$datas->updated_at }}</td>
                          <td>{{$datas->tgl_cuti_mulai }} - {{$datas->tgl_cuti_selesai }}</td>
                          <td>{{$datas->lama_cuti }} Hari</td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                <br/><br/><br/><br/><br/><br/>
                  <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-6">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                      <p class="">Mengatahui</p>
                      <br/><br/><br/>
                      <p class="lead">{{$datas->atasan}}</p>
                    <p>{{$datas->jabatan_Atasan}}</p>
                      
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </section>
                <!-- /.content -->
              </div>
</div>
<!-- ./wrapper -->
<script type="text/javascript">

window.print();

</script>
</body>
</html>

