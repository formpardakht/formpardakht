@extends('fp::layouts.home')

@section('page-title')
  {{ lang('lang.not_found') }}
@endsection

@section('content')
  <div class="container-contact100">
    <div class="wrap-contact100" style="width: auto">
      <div class="contact100-form">
        <span class="contact100-form-title" style="padding-bottom: 0">
          {{ lang('lang.not_found') }}
        </span>
      </div>
    </div>
  </div>
@endsection
