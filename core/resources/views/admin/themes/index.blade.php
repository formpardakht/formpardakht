@extends('fp::layouts.admin')

@section('page-title'){{ lang('lang.update') }}@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ lang('lang.themes') }}</div>
        <div class="card-body">
            @foreach($themes as $theme)
                <a href="{{ route('admin-themes-update', ['slug' => $theme['slug']]) }}" class="card box ml-2 mb-5">
                    <div class="card-body" style="background-image: url('{{ $theme["screenshot"] }}')" title="{{ $theme['author'] }}"></div>
                    <div class="card-footer">
                        {{ $theme['name'] }}
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
            height: 150px;
            color: inherit;
            text-decoration: none;
            display: inline-block;
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card.box .card-body {
            text-align: center;
            cursor: pointer;
            width: 100%;
            height: 100%;
            padding: 10px;
            position: relative;
            background-repeat: no-repeat;
            background-size: contain;
            background-origin: content-box;
        }


    </style>
@endpush