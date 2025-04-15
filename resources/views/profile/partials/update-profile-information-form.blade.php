<section>
    <header>
        <h5 style="color: var(--primary-color); margin-bottom: 0.5rem; font-weight: 500;">{{ __('Profile Information') }}</h5>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; color: var(--text-primary);">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); background-color: var(--surface-color); color: var(--text-primary);" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <span style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--text-primary);">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); background-color: var(--surface-color); color: var(--text-primary);" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <span style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div style="background-color: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107; padding: 1rem; margin-bottom: 1.5rem; border-radius: var(--border-radius);">
                <span style="color: var(--text-primary);">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" style="background: none; border: none; color: var(--primary-color); text-decoration: underline; cursor: pointer; padding: 0; margin-left: 8px;">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </span>
                @if (session('status') === 'verification-link-sent')
                    <span style="color: #4caf50; display: block; margin-top: 0.5rem;">{{ __('A new verification link has been sent to your email address.') }}</span>
                @endif
            </div>
        @endif

        <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 1.5rem;">
            @if (session('status') === 'profile-updated')
                <span style="color: #4caf50; margin-right: 1rem;">{{ __('Saved.') }}</span>
            @endif
            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
        </div>
    </form>
</section>
