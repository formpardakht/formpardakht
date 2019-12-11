@extends('layouts.admin')

@section('page-title'){{ __('lang.themes') }}@endsection

@section('content')
    <div class="alert alert-info">قالب های جدید رو میتونید از <a href="https://formpardakht.com/themes" target="_blank">اینجا</a> دانلود کنید</div>
    <div class="card">
        <div class="card-header">{{ __('lang.install_theme') }}</div>
        <div class="card-body">
            <form action="{{ route('admin.themes.install') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="file" name="file">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">{{ __('lang.install') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">{{ __('lang.themes') }}</div>
        <div class="card-body">
            @if(count($themes))
                @foreach($themes as $theme)
                    <a href="{{ route('admin.themes.update', ['slug' => $theme['slug']]) }}" class="card box @if(site_config('theme') == $theme['slug']) active @endif">
                        <div class="card-body" style="background-image: url('{{ isset($theme["screenshot"]) ? $theme["screenshot"] : asset('assets/img/no-screenshot.png') }}')" title="{{ $theme['author'] }}"></div>
                        <div class="card-footer">
                            <p>{{ $theme['name'] }}</p>
                            <b>{{ __('lang.version') }}: {{ $theme['version'] }}</b>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="alert alert-warning">هنوز قالبی نصب نکرده اید.</div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card.box {
            width: 150px;
            color: inherit;
            text-decoration: none;
            display: inline-block;
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-left: 10px;
            margin-bottom: 10px;
        }

        .card.box .card-body {
            text-align: center;
            cursor: pointer;
            width: 100%;
            height: 150px;
            padding: 10px;
            position: relative;
            background-repeat: no-repeat;
            background-origin: content-box;
            background-size: contain;
            background-position: center;
        }

        .card.box.active {
            box-shadow: 0 0 3px 1px #007eff;
        }
    </style>
@endpush
