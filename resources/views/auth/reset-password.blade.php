<x-material-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="input-field">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
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
                    Reset Password
                    <i class="material-icons right">refresh</i>
                </button>
            </div>
        </div>
    </form>
</x-material-guest-layout>
