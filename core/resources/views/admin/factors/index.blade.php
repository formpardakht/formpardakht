@extends('layouts.admin')

@section('page-title'){{ __('lang.factors') }}@endsection

@section('content')
  <div class="card mb-4">
    <div class="card-header">{{ __('lang.filter') }}</div>
    <div class="card-body">
      <form action="{{ route('admin.factors.filter') }}" class="form-inline">
        <div class="form-group mb-2">
          <label for="txt-id" class="sr-only">{{ __('lang.id') }}</label>
          <input type="text" name="id" class="form-control" id="txt-id" placeholder="{{ __('lang.id') }}" value="@if(isset($inputs['id'])){{ $inputs['id'] }}@endif">
        </div>
        <div class="form-group mx-2 mb-2">
          <button class="btn btn-primary">{{ __('lang.filter') }}</button>
        </div>
      </form>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      {{ __('lang.factors') }}
      <a href="{{ route('admin-factors-add') }}" class="btn btn-success btn-sm float-left">{{ __('lang.add_new_factor') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table text-center table-hover table-striped table-bordered">
          <thead>
          <tr>
            <th>{{ __('lang.id') }}</th>
            <th>{{ __('lang.title') }}</th>
            <th>{{ __('lang.amount') }}</th>
            <th>{{ __('lang.status') }}</th>
            <th>{{ __('lang.actions') }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($factors as $factor)
            <tr>
              <td>{{ $factor->id }}</td>
              <td>
                <a href="{{ route('factor', ['id' => $factor->id]) }}" target="_blank">{{ $factor->title }}</a>
              </td>
              <td>{{ custom_money_format($factor->amount) }}</td>
              <td>
                @if($factor->paid)
                  <span class="badge badge-success">{{ __('lang.paid') }}</span>
                  <a href="{{ route('admin-transactions-detail', ['id' => $factor->transaction_id]) }}" class="btn-popup">{{ __('lang.transaction_details') }}</a>
                @else
                  <span class="badge badge-danger">{{ __('lang.not_paid') }}</span>
                @endif
              </td>
              <td>
                @if(!$factor->paid)
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ __('lang.send_factor') }}
                    </button>
                    <div class="dropdown-menu">
                      <a href="https://t.me/share/url?url={{ site_config('site_url') . '/factor/' . $factor->id }}" class="dropdown-item" target="_blank">{{ __('lang.telegram') }}</a>
                      <a href="https://api.whatsapp.com/send?text={{ site_config('site_url') . '/factor/' . $factor->id }}" class="dropdown-item" target="_blank">{{ __('lang.whatsapp') }}</a>
                    </div>
                  </div>
                @endif
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('lang.actions') }}
                  </button>
                  <div class="dropdown-menu">
                    @if(!$factor->paid)
                      <a href="{{ route('admin-factors-edit', ['id' => $factor->id]) }}" class="dropdown-item">{{ __('lang.edit') }}</a>
                    @endif
                    <a href="{{ route('admin-factors-delete', ['id' => $factor->id]) }}" class="dropdown-item">{{ __('lang.delete') }}</a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <div class="text-center">
        @include('extensions.pagination', ['paginator' => $factors])
      </div>
    </div>
  </div>
@endsection
