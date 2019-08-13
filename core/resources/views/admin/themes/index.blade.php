@extends('fp::layouts.admin')

@section('page-title'){{ lang('lang.update') }}@endsection

@section('content')
    <div class="alert alert-info">قالب های جدید رو میتونید از <a href="https://formpardakht.com/themes" target="_blank">اینجا</a> دانلود کنید</div>
    <div class="card">
        <div class="card-header">{{ lang('lang.install_theme') }}</div>
        <div class="card-body">
            <form action="{{ route('admin-themes-install') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="file" class="form-control" name="file">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">{{ lang('lang.install') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">{{ lang('lang.themes') }}</div>
        <div class="card-body">
            @foreach($themes as $theme)
                <a href="{{ route('admin-themes-update', ['slug' => $theme['slug']]) }}" class="card box @if(site_config('theme') == $theme['slug']) active @endif">
                    <div class="card-body" style="background-image: url('{{ $theme["screenshot"] }}')" title="{{ $theme['author'] }}"></div>
                    <div class="card-footer">
                        <p>{{ $theme['name'] }}</p>
                        <b>{{ lang('lang.version') }}: {{ $theme['version'] }}</b>
                    </div>
                </a>
            @endforeach
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
            background-size: contain;
            background-origin: content-box;
        }

        .card.box.active {
            box-shadow: 0 0 3px 1px #007eff;
        }
    </style>
@endpush