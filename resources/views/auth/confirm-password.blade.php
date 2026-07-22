<x-guest-layout>
    <x-auth-page title="تأكيد كلمة المرور" subtitle="هذه منطقة آمنة. الرجاء تأكيد كلمة المرور للمتابعة.">
        <div class="alert-message">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <div class="input-field">
                    <span class="input-icon">🔒</span>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="ادخل كلمة المرور" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-400" />
            </div>

            <button type="submit" class="btn-submit">تأكيد</button>
        </form>
    </x-auth-page>
</x-guest-layout>
