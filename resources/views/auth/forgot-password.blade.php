<x-guest-layout>
    <x-auth-page title="نسيت كلمة المرور" subtitle="أدخل بريدك الإلكتروني لنرسل لك رابط إعادة التعيين">
        <div class="alert-message">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <x-auth-session-status class="alert-message" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <div class="input-field">
                    <span class="input-icon">✉️</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="ادخل بريدك الإلكتروني" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-400" />
            </div>

            <button type="submit" class="btn-submit">إرسال رابط إعادة التعيين</button>
        </form>

        <div class="login-footer">تذكرت كلمة المرور؟ <a href="{{ route('login') }}">تسجيل الدخول</a></div>
    </x-auth-page>
</x-guest-layout>
