<x-material-guest-layout>
    <h5 class="center-align blue-text text-darken-3">Camp Access Management System</h5>
    <p class="center-align">Request new access credentials for the system</p>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="input-field">
            <i class="material-icons prefix">person</i>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            <label for="name">Full Name</label>
            @error('name')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="input-field">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            <label for="email">Email</label>
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-field">
            <i class="material-icons prefix">lock</i>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            <label for="password">Password</label>
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-field">
            <i class="material-icons prefix">lock_outline</i>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            <label for="password_confirmation">Confirm Password</label>
            @error('password_confirmation')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col s12">
                <button type="submit" class="btn waves-effect waves-light btn-custom right">
                    Request Access
                    <i class="material-icons right">person_add</i>
                </button>
                
                <a class="link-custom" href="{{ route('login') }}">
                    Already have access?
                </a>
            </div>
        </div>
    </form>
</x-material-guest-layout>
