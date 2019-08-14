@extends('fp::layouts.home')

@section('page-title')
    {{ $form->title }}
@endsection

@section('content')
    <div class="container-contact100">
        <div class="wrap-contact100">
            <form class="contact100-form validate-form" action="{{ route('form', ['id' => $form->id]) }}" method="post">
                {!! csrf_field() !!}
                <span class="contact100-form-title">
					{{ $form->title }}
				</span>
                @if($form->description)
                    <p class="contact100-form-description">{!! nl2br2($form->description) !!}</p>
                @endif
                @if($form->image)
                    <div class="text-center">
                        <a href="{{ asset($form->image) }}" target="_blank">
                            <img src="{{ asset($form->image) }}" class="img-thumbnail mb-3" alt="{{ $form->title }}">
                        </a>
                    </div>
                @endif
                @if($form->fields)
                    @foreach($form->fields as $key => $f)
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="{{ $f['name'] }}" @if($f['required']==1) required @endif value="{{ old($f['name']) }}" placeholder="{{ $f['label'] }}"/>
                        </div>
                    @endforeach
                @endif
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="amount" @if($form->amount) disabled="disabled" value="{{ custom_money_format($form->amount) }} {{ lang('lang.rial') }}" @else value="{{ old('amount') }}" @endif placeholder="{{ lang('lang.amount') }}" required/>
                </div>
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
