<x-guest-layout>
    <x-auth-page title="تحقق من بريدك الإلكتروني" subtitle="افتح الرسالة المرسلة إليك ثم اضغط على رابط التحقق.">
        <div class="alert-message">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert-message">{{ __('A new verification link has been sent to the email address you provided during registration.') }}</div>
        @endif

        <div class="button-group">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-submit">إعادة إرسال رسالة التحقق</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary">تسجيل الخروج</button>
            </form>
        </div>
    </x-auth-page>
</x-guest-layout>
