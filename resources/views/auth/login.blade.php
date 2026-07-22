<x-guest-layout>
    <x-auth-page title="تسجيل الدخول" subtitle="ادخل بياناتك لتسجيل الدخول إلى حسابك">
        <x-auth-session-status class="alert-message" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <div class="input-field">
                    <span class="input-icon">✉️</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="ادخل بريدك الإلكتروني" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-400" />
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <div class="input-field">
                    <span class="input-icon">🔒</span>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="ادخل كلمة المرور" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-400" />
            </div>

            <div class="checkbox-row">
                <label for="remember_me">
                    <input id="remember_me" name="remember" type="checkbox" />
                    تذكرني
                </label>
                @if (Route::has('password.request'))
                    <a class="link-secondary" href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">تسجيل الدخول</button>
        </form>

        <div class="login-footer">ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a></div>
    </x-auth-page>
</x-guest-layout>
