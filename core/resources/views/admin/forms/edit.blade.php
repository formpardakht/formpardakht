@extends('layouts.admin')

@section('page-title'){{ __('lang.edit_form') }}@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      {{ __('lang.edit_form') }}
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <form method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="txt-title" class="label">{{ __('lang.title') }} ({{ __('lang.required') }})</label>
              <input type="text" class="form-control" id="txt-title" name="title" value="{{ $form->title }}">
            </div>
            <div class="form-group">
              <label for="txt-description" class="label">{{ __('lang.description') }} ({{ __('lang.optional') }})</label>
              <textarea name="description" id="txt-description" class="form-control" rows="3">{{ $form->description }}</textarea>
            </div>
            <div class="form-group">
              <label for="txt-amount" class="label">{{ __('lang.amount') }} ({{ __('lang.optional') }})</label>
              <input type="text" class="form-control" id="txt-amount" name="amount" value="{{ $form->amount }}" placeholder="{{ __('lang.to_optional_amount_leave_empty') }}">
            </div>
            <div id="advanced">
              <div class="form-group">
                <label for="txt-pay-limit" class="label">{{ __('lang.form_size') }}</label>
                <div>
                  <div class="form-check form-check-inline pl-0 ml-0 mr-2">
                    <input class="form-check-input ml-0 mr-2" type="radio" name="form_size" id="radio-lg" value="12" @if($form->form_size == 12) checked @endif>
                    <label class="form-check-label" for="radio-lg">{{ __('lang.form_size_lg') }}</label>
                  </div>
                  <div class="form-check form-check-inline pl-0 ml-0 mr-2">
                    <input class="form-check-input ml-0 mr-2" type="radio" name="form_size" id="radio-md" value="8" @if($form->form_size == 8) checked @endif>
                    <label class="form-check-label" for="radio-md">{{ __('lang.form_size_md') }}</label>
                  </div>
                  <div class="form-check form-check-inline pl-0 ml-0 mr-2">
                    <input class="form-check-input ml-0 mr-2" type="radio" name="form_size" id="radio-sm" value="4" @if($form->form_size == 4) checked @endif>
                    <label class="form-check-label" for="radio-sm">{{ __('lang.form_size_sm') }}</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="txt-pay-limit" class="label">{{ __('lang.pay_limit') }} ({{ __('lang.optional') }})</label>
                <input type="text" class="form-control" id="txt-pay-limit" name="pay_limit" value="{{ $form->pay_limit }}" placeholder="{{ __('lang.to_unlimited_payment_leave_empty') }}">
              </div>
              <div class="form-group">
                <label for="file-image" class="label">{{ __('lang.image') }} ({{ __('lang.optional') }})</label>
                <input type="file" class="form-control" id="file-image" name="image" accept="image/*">
              </div>
              <div class="form-group">
                <label class="label">{{ __('lang.fields') }} ({{ __('lang.optional') }})</label>
                <a href="javascript:" class="float-left" onclick="addNewField()">{{ __('lang.add_new_field') }}</a>
                <div id="fields">
                  @foreach($form->fields as $key => $field)
                    <div class="form-group field" id="field{{ $key }}">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <label class="input-group-text">
                            <input type="checkbox" name="required_fields[]" value="required_{{ $key }}" class="mr-1" @if($field['required']) checked @endif> {{ __('lang.required_field') }}
                          </label>
                        </div>
                        <input type="text" name="fields[]" class="form-control" value="{{ $field['label'] }}">
                        <a href="javascript:" class="btn btn-danger delete-field">حذف</a>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-success">{{ __('lang.edit') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .field {
      position: relative;
    }

    .delete-field {
      position: absolute;
      left: 0;
      top: 0;
      z-index: 9999;
    }
  </style>
@endpush

@push('scripts')
  <script>
    let fields = 1;

    function showAdvanced() {
      $('#advanced').show();
      $('#btn-advanced').hide();
    }

    function addNewField() {
      $('#fields').append('<div class="form-group field" id="field' + (fields + 1) + '"><div class="input-group field"><div class="input-group-prepend"><label class="input-group-text"><input type="checkbox" name="required_fields[]" value="required_' + fields + '" class="mr-1"> فیلد اجباری</label></div><input type="text" name="fields[]" class="form-control" placeholder="عنوان فیلد"><a href="javascript:" class="btn btn-danger delete-field">حذف</a></div></div>')
      fields++;
    }

    $('#fields').on('click', '.delete-field', function () {
      $(this).parent().parent('.field').remove();
    })
  </script>
@endpush
