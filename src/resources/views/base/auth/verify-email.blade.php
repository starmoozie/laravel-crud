@extends(starmoozie_view('layouts.plain'))

@section('content')
  <section class="section">
    <div class="container">
      <div class="flex-center">
        <div class="width-large">

          <div class="card box-shadow-small">
            <div class="card-header">
              <h2 class="text-center">{{ __('Verify Your Email') }}</h2>

              <p>
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
              </p>

            </div>

            <div class="card-body padding-remove-top">
              <div class="margin">
                <form method="POST" action="{{ route('verification.send') }}">
                  @csrf

                  <button class="btn btn-sm btn-primary shadow-sm" type="submit">
                    {{ __('Resend Verification Email') }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection