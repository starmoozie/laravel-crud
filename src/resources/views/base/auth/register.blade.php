@extends(starmoozie_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4">{{ trans('starmoozie::base.register') }}</h3>
            <div class="card shadow">
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('starmoozie.auth.register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="name">{{ trans('starmoozie::base.name') }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="{{ starmoozie_authentication_column() }}">{{ config('starmoozie.base.authentication_column_name') }}</label>

                            <div>
                                <input type="{{ starmoozie_authentication_column()=='email'?'email':'text'}}" class="form-control{{ $errors->has(starmoozie_authentication_column()) ? ' is-invalid' : '' }}" name="{{ starmoozie_authentication_column() }}" id="{{ starmoozie_authentication_column() }}" value="{{ old(starmoozie_authentication_column()) }}">

                                @if ($errors->has(starmoozie_authentication_column()))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first(starmoozie_authentication_column()) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password">{{ trans('starmoozie::base.password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password_confirmation">{{ trans('starmoozie::base.confirm_password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn shadow btn-block btn-primary">
                                    {{ trans('starmoozie::base.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (starmoozie_users_have_email() && config('starmoozie.base.setup_password_recovery_routes', true))
                <div class="text-center"><a href="{{ route('starmoozie.auth.password.reset') }}">{{ trans('starmoozie::base.forgot_your_password') }}</a></div>
            @endif
            <div class="text-center"><a href="{{ route('starmoozie.auth.login') }}">{{ trans('starmoozie::base.login') }}</a></div>
        </div>
    </div>
@endsection
