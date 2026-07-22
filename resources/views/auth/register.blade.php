<x-guest-layout>
    <x-auth-page title="إنشاء حساب جديد" subtitle="سجل حسابك لاكمال رحلة التعلم">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">الاسم</label>
                <div class="input-field">
                    <span class="input-icon">👤</span>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="ادخل اسمك" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-rose-400" />
            </div>

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <div class="input-field">
                    <span class="input-icon">✉️</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="ادخل بريدك الإلكتروني" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-400" />
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <div class="input-field">
                    <span class="input-icon">🔒</span>
                    <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="ادخل كلمة المرور" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-400" />
            </div>

            <div class="form-group">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <div class="input-field">
                    <span class="input-icon">🔒</span>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="اعد كتابة كلمة المرور" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-rose-400" />
            </div>

            <button type="submit" class="btn-submit">إنشاء حساب</button>
        </form>

        <div class="login-footer">هل لديك حساب؟ <a href="{{ route('login') }}">تسجيل الدخول</a></div>
    </x-auth-page>
</x-guest-layout>
