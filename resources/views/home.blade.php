@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->

  <!-- /.content-header -->
  @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<router-view></router-view>
<vue-progress-bar></vue-progress-bar>


@endsection
