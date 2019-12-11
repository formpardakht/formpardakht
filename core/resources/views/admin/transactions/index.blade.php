@extends('layouts.admin')

@section('page-title'){{ __('lang.transactions') }}@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">{{ __('lang.filter') }}</div>
        <div class="card-body">
            <form action="{{ route('admin-transactions-filter') }}" class="form-inline">
                <div class="form-group mb-2">
                    <label for="txt-id" class="sr-only">{{ __('lang.id') }}</label>
                    <input type="text" name="id" class="form-control" id="txt-id" placeholder="{{ __('lang.id') }}" value="@if(isset($inputs['id'])){{ $inputs['id'] }}@endif">
                </div>
                <div class="form-group mx-2 mb-2">
                    <label for="txt-card-number" class="sr-only">{{ __('lang.card_number') }}</label>
                    <input type="text" name="card_number" class="form-control" id="txt-card-number" placeholder="{{ __('lang.card_number') }}" value="@if(isset($inputs['card_number'])){{ $inputs['card_number'] }}@endif" title="0000-0000-0000-0000">
                </div>
                <div class="form-group mx-2 mb-2">
                    <label for="select-type" class="sr-only">{{ __('lang.type') }}</label>
                    <select name="type" id="select-type" class="form-control">
                        <option value="" selected>{{ __('lang.type') }}</option>
                        @foreach(\App\Transaction::$typeLabels as $key => $value)
                            <option value="{{ $key }}" @if(isset($inputs['type']) && $inputs['type'] == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mx-2 mb-2">
                    <label for="select-status" class="sr-only">{{ __('lang.status') }}</label>
                    <select name="status" id="select-status" class="form-control">
                        <option value="" @if(isset($inputs['status']) && $inputs['status'] == '') selected @endif>{{ __('lang.status') }}</option>
                        <option value="1" @if(isset($inputs['status']) && $inputs['status'] == '1') selected @endif>{{ __('lang.success') }}</option>
                        <option value="0" @if(isset($inputs['status']) && $inputs['status'] == '0') selected @endif>{{ __('lang.failed') }}</option>
                    </select>
                </div>
                <div class="form-group mx-2 mb-2">
                    <button class="btn btn-primary">{{ __('lang.filter') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">{{ __('lang.transactions') }}</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.type') }}</th>
                        <th>{{ __('lang.amount') }}</th>
                        <th>{{ __('lang.date') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ \App\Transaction::$typeLabels[$transaction->type] }}</td>
                            <td>{{ custom_money_format($transaction->amount) }}</td>
                            <td>{{ $transaction->full_jalali_created_at }}</td>
                            <td>
                                <span class="{{ $transaction->status && $transaction->verified ? 'text-success' : 'text-danger' }}">{{ $transaction->status && $transaction->verified ? __('lang.success') : __('lang.failed') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin-transactions-detail', ['id' => $transaction->id]) }}" class="btn-popup">{{ __('lang.details') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                @include('extensions.pagination', ['paginator' => $transactions])
            </div>
        </div>
    </div>
@endsection
