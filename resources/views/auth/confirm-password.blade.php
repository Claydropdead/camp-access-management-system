<x-material-guest-layout>
    <p class="center-align">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="input-field">
            <i class="material-icons prefix">lock</i>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            <label for="password">Password</label>
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col s12">
                <button type="submit" class="btn waves-effect waves-light btn-custom right">
                    Confirm
                    <i class="material-icons right">check_circle</i>
                </button>
            </div>
        </div>
    </form>
</x-material-guest-layout>
