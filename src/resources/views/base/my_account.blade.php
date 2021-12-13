<?php
    $model        = config('starmoozie.base.user_model_fqn');
    $model        = new $model();
    $column       = 'mobile';
    $check_column = Schema::hasColumn($model->getTable(), $column);
    $mobile_label = ucwords($column);
    $mobile_field = $column;
?>

@extends(starmoozie_view('blank'))

@section('after_styles')
    <style media="screen">
        .starmoozie-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@php
  $breadcrumbs = [
      trans('starmoozie::crud.admin') => url(config('starmoozie.base.route_prefix'), 'dashboard'),
      trans('starmoozie::base.my_account') => false,
  ];
@endphp

@section('header')
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h1>{{ trans('starmoozie::base.my_account') }}</h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">

        @if (session('success'))
        <div class="col-lg-12">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if ($errors->count())
        <div class="col-lg-12">
            <div class="alert alert-danger">
                <ul class="mb-1">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- UPDATE INFO FORM --}}
        <div class="col-lg-12">
            <form class="form" action="{{ route('starmoozie.account.info.store') }}" method="post">

                {!! csrf_field() !!}

                <div class="card padding-10 shadow-sm">

                    <div class="card-header">
                        {{ trans('starmoozie::base.update_account_info') }}
                    </div>

                    <div class="card-body starmoozie-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-{{ $check_column ? '4' : '6' }} form-group">
                                @php
                                    $label = trans('starmoozie::base.name');
                                    $field = 'name';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-user"></i>
                                        </span>
                                    </div>
                                    <input required class="form-control" type="text" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>
                            </div>

                            <div class="col-md-{{ $check_column ? '4' : '6' }} form-group">
                                @php
                                    $label = config('starmoozie.base.authentication_column_name');
                                    $field = starmoozie_authentication_column();
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-envelope"></i>
                                        </span>
                                    </div>
                                    <input required class="form-control" type="{{ starmoozie_authentication_column()=='email'?'email':'text' }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>
                            </div>

                            @if($check_column)
                                <div class="col-md-4 form-group">
                                    <label class="required">{{ $mobile_label }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-mobile-alt"></i>
                                            </span>
                                        </div>
                                        <input required class="form-control" type="text" pattern="[0-9]{6,15}" name="{{ $mobile_field }}" value="{{ old($mobile_field) ? old($mobile_field) : $user->$mobile_field }}">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm shadow-sm"><i class="la la-save"></i> {{ trans('starmoozie::base.save') }}</button>
                    </div>
                </div>

            </form>
        </div>
        
        {{-- CHANGE PASSWORD FORM --}}
        <div class="col-lg-12">
            <form class="form" action="{{ route('starmoozie.account.password') }}" method="post">

                {!! csrf_field() !!}

                <div class="card padding-10 shadow-sm">

                    <div class="card-header">
                        {{ trans('starmoozie::base.change_password') }}
                    </div>

                    <div class="card-body starmoozie-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('starmoozie::base.old_password');
                                    $field = 'old_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('starmoozie::base.new_password');
                                    $field = 'new_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('starmoozie::base.confirm_password');
                                    $field = 'confirm_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm shadow-sm"><i class="la la-save"></i> {{ trans('starmoozie::base.change_password') }}</button>
                    </div>

                </div>

            </form>
        </div>

    </div>
@endsection
