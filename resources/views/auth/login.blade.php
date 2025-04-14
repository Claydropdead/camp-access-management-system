<x-material-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="status-success">
            {{ session('status') }}
        </div>
    @endif

    <h5 class="center-align blue-text text-darken-3">Camp Access Management System</h5>
    <p class="center-align">Welcome back! Please login to your account.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-field">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <label for="email">Email</label>
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-field">
            <i class="material-icons prefix">lock</i>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            <label for="password">Password</label>
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="row">
            <div class="col s12">
                <label>
                    <input type="checkbox" name="remember" class="filled-in" {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember me</span>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <button type="submit" class="btn waves-effect waves-light btn-custom right">
                    Access System
                    <i class="material-icons right">login</i>
                </button>
                
                @if (Route::has('password.request'))
                    <a class="link-custom" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>
        </div>
        
        @if (Route::has('register'))
            <div class="row center-align">
                <div class="col s12">
                    <span>Don't have an account?</span>
                    <a class="link-custom" href="{{ route('register') }}">Request Access</a>
                </div>
            </div>
        @endif
    </form>
</x-material-guest-layout>
