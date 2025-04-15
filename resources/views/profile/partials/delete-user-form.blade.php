<section>
    <header>
        <h5 style="color: var(--error-color); margin-bottom: 0.5rem; font-weight: 500;">{{ __('Delete Account') }}</h5>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </header>
    <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
        @csrf
        @method('delete')
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="delete_password" style="display: block; margin-bottom: 0.5rem; color: var(--text-primary);">{{ __('Password') }}</label>
            <input id="delete_password" name="password" type="password" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); background-color: var(--surface-color); color: var(--text-primary);" required autocomplete="current-password">
            @error('password')
                <span style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
            <button style="background-color: var(--error-color); color: white; border: none; border-radius: 4px; padding: 0.5rem 1rem; font-weight: 500; cursor: pointer;" type="submit">{{ __('Delete Account') }}</button>
        </div>
    </form>
</section>
