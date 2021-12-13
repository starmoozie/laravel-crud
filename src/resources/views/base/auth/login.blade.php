@extends(starmoozie_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4">{{ trans('starmoozie::base.login') }}</h3>
            <div class="card">
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('starmoozie.auth.login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="{{ $username }}">{{ config('starmoozie.base.authentication_column_name') }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}" autofocus>

                                @if ($errors->has($username))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first($username) }}</strong>
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
                            <div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{ trans('starmoozie::base.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-sm btn-primary">
                                    {{ trans('starmoozie::base.login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (starmoozie_users_have_email() && config('starmoozie.base.setup_password_recovery_routes', true))
                <div class="text-center"><a href="{{ route('starmoozie.auth.password.reset') }}">{{ trans('starmoozie::base.forgot_your_password') }}</a></div>
            @endif
            @if (config('starmoozie.base.registration_open'))
                <div class="text-center"><a href="{{ route('starmoozie.auth.register') }}">{{ trans('starmoozie::base.register') }}</a></div>
            @endif
        </div>
    </div>
@endsection