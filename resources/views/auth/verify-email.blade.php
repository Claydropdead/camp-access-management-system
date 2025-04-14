<x-material-guest-layout>
    <div class="center-align">
        <p>
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="status-success center-align">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="row">
        <div class="col s12 m6">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn waves-effect waves-light btn-custom">
                    {{ __('Resend Verification Email') }}
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>

        <div class="col s12 m6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn waves-effect waves-light red lighten-1">
                    {{ __('Log Out') }}
                    <i class="material-icons right">logout</i>
                </button>
            </form>
        </div>
    </div>
</x-material-guest-layout>
