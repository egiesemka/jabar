@extends('layouts.print')

@section('content')
<!-- Content Header (Page header) -->

  <!-- /.content-header -->
  @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<router-view name="print"></router-view>
<vue-progress-bar></vue-progress-bar>


@endsection
