<x-guest-layout>
    <x-auth-page title="إعادة تعيين كلمة المرور" subtitle="ادخل البريد وكلمة المرور الجديدة لتفعيل الحساب.">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <div class="input-field">
                    <span class="input-icon">✉️</span>
                    <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="ادخل بريدك الإلكتروني" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-400" />
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور الجديدة</label>
                <div class="input-field">
                    <span class="input-icon">🔒</span>
                    <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="ادخل كلمة المرور الجديدة" />
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

            <button type="submit" class="btn-submit">تحديث كلمة المرور</button>
        </form>
    </x-auth-page>
</x-guest-layout>
