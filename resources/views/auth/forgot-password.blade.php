<x-material-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="status-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-field">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            <label for="email">Email</label>
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col s12">
                <button type="submit" class="btn waves-effect waves-light btn-custom right">
                    Email Password Reset Link
                    <i class="material-icons right">send</i>
                </button>
                
                <a class="link-custom" href="{{ route('login') }}">
                    Back to login
                </a>
            </div>
        </div>
    </form>
</x-material-guest-layout>
