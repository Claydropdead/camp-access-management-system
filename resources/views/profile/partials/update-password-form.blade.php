<section>
    <header>
        <h5 style="color: var(--primary-color); margin-bottom: 0.5rem; font-weight: 500;">{{ __('Update Password') }}</h5>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="current_password" style="display: block; margin-bottom: 0.5rem; color: var(--text-primary);">{{ __('Current Password') }}</label>
            <input id="current_password" name="current_password" type="password" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); background-color: var(--surface-color); color: var(--text-primary);" autocomplete="current-password" required>
            @error('current_password')
                <span style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="password" style="display: block; margin-bottom: 0.5rem; color: var(--text-primary);">{{ __('New Password') }}</label>
            <input id="password" name="password" type="password" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); background-color: var(--surface-color); color: var(--text-primary);" autocomplete="new-password" required>
            @error('password')
                <span style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; color: var(--text-primary);">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); background-color: var(--surface-color); color: var(--text-primary);" autocomplete="new-password" required>
            @error('password_confirmation')
                <span style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 1.5rem;">
            @if (session('status') === 'password-updated')
                <span style="color: #4caf50; margin-right: 1rem;">{{ __('Password updated.') }}</span>
            @endif
            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
        </div>
    </form>
</section>
