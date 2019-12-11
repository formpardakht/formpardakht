@extends('layouts.admin')

@section('page-title'){{ __('lang.update') }}@endsection

@section('content')
  <div class="card">
    <div class="card-header">{{ __('lang.update') }}</div>
    <div class="card-body">
      <p>{{ __('lang.current_version') }} : <b>{{ config('app.version') }}</b> (<a href="https://formpardakht.com/blog/{{ str_replace('.', '-', config('app.version')) }}" target="_blank">{{ __('lang.current_version_changes') }}</a>)</p>
      @if($latestRelease)
        <p>{{ __('lang.there_is_new_release') }} : <b>{{ $latestRelease->version }}</b> (<a href="https://formpardakht.com/blog/{{ str_replace('.', '-', $latestRelease->version) }}" target="_blank">{{ __('lang.new_version_changes') }}</a>)</p>
        <a href="{{ route('admin.update.install') }}" class="btn btn-success" id="btn-update" data-loading-text="{{ __('lang.updating') }}">{{ __('lang.install_update') }}</a>
      @else
        <p>{{ __('lang.you_are_using_latest_version') }}</p>
      @endif
      <a href="" class="btn btn-primary">{{ __('lang.check') }}</a>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $('#btn-update').on('click', function () {
      $(this).text($(this).data('loading-text')).addClass('disabled').attr('disabled', 'disabled');
    });
  </script>
@endpush
