@extends('fp::layouts.home')

@section('page-title')
  {{ $factor->title }}
@endsection

@section('content')
  <div class="container-contact100">
    <div class="wrap-contact100" style="width: unset">
      <form action="{{ route('factor', ['id' => $factor->id]) }}" method="post">
        {!! csrf_field() !!}
        <span class="contact100-form-title">
            {{ $factor->title }}
        </span>
        <div class="table-responsive">
          <table class="table text-center table-hover table-striped table-bordered">
            <thead>
              <tr>
                <th>{{ lang('lang.row') }}</th>
                <th>{{ lang('lang.item_name') }}</th>
                <th>{{ lang('lang.item_count') }}</th>
                <th>{{ lang('lang.item_price') }}</th>
                <th>{{ lang('lang.item_description') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($factor->items as $key => $item)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $item['name'] }}</td>
                  <td>{{ $item['count'] }}</td>
                  <td>{{ $item['price'] }}</td>
                  <td>{{ $item['description'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <table class="table text-center table-hover table-striped table-bordered">
            <tbody>
              <tr>
                <th>{{ lang('lang.tax') }}</th>
                <td>{{ $factor->tax }}</td>
                <th>{{ lang('lang.total_amount') }}</th>
                <td>{{ custom_money_format($factor->amount) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        @include('fp::extensions.alert')
        <div class="container-contact100-form-btn">
          <div class="wrap-contact100-form-btn">
            <div class="contact100-form-bgbtn"></div>
            <button class="contact100-form-btn">
              <span>
                  <i class="fa fa-credit-card" aria-hidden="true"></i>
                  {{ lang('lang.pay') }}
              </span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
