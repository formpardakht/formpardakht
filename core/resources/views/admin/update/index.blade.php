@extends('fp::layouts.admin')

@section('page-title'){{ lang('lang.update') }}@endsection

@section('content')
  <div class="card">
    <div class="card-header">{{ lang('lang.update') }}</div>
    <div class="card-body">
      <p>{{ lang('lang.current_version') }} : <b>{{ config('app.version') }}</b> (<a href="https://formpardakht.com/blog/{{ str_replace('.', '-', config('app.version')) }}" target="_blank">{{ lang('lang.current_version_changes') }}</a>)</p>
      @if($latestRelease)
        <p>{{ lang('lang.there_is_new_release') }} : <b>{{ $latestRelease->version }}</b> (<a href="https://formpardakht.com/blog/{{ str_replace('.', '-', $latestRelease->version) }}" target="_blank">{{ lang('lang.new_version_changes') }}</a>)</p>
        <a href="{{ route('admin-update-install') }}" class="btn btn-success" id="btn-update" data-loading-text="{{ lang('lang.updating') }}">{{ lang('lang.install_update') }}</a>
      @else
        <p>{{ lang('lang.you_are_using_latest_version') }}</p>
      @endif
      <a href="" class="btn btn-primary">{{ lang('lang.check') }}</a>
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
