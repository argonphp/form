@extends('ArgonForm::layout.base')

@php
  if (!isset($method)) $method = "post";
@endphp

@section('_content')
  <form method="<?php if($method == 'get') echo $method; else echo 'post'; ?>" action="{{ $action ?? '' }}">
    @csrf
    @if ($method != 'get' and $method != "post")
      @method($method)
    @endif
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
    @if (isset($title) or isset($titleForm))

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $titleForm ?? ($title ?? "") }}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
    @endif

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
 
          <!-- /.col-lg-12 -->
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
              	@yield('content')
              </div>

              <div class="card-footer text-right">
                @yield('buttons')
              </div>
            </div>
          </div>
          <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </form>
@endsection

@style
<style type="text/css">
  div.card-footer .hover {
    color: #fff;
    background-color: #0069d9;
    border-color: #0062cc;
  }
</style>
@endstyle

@script
<script type="text/javascript">
  // Hover effect on focusing buttons
  // Very usefull to know if navigating on tab the button is selected
  $(document).ready(function() {
    $('div.card-footer .btn').on('focus', function() {
      $(this).addClass('hover');
    });
    $('div.card-footer .btn').on('blur', function() {
      $(this).removeClass('hover');
    });
  });
</script>
@endscript