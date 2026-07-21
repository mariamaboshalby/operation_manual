
<x-guest-layout>
    <div class="text-center">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full border border-amber-300/20 bg-amber-300/10 text-3xl text-amber-200 shadow-[0_0_0_8px_rgba(244,197,66,0.06)]">
            ☕
        </div>
        <h1 class="mt-6 text-4xl font-semibold tracking-tight text-slate-100">Welcome Back</h1>
        <p class="mt-3 text-sm text-slate-400">سعداء بعودتك! سجل الدخول لمتابعة رحلتك التعليمية</p>
        <div class="mt-4 mx-auto h-[3px] w-24 rounded-full bg-gradient-to-r from-amber-400 via-cyan-400 to-slate-200"></div>
    </div>

    <x-auth-session-status class="mt-6 text-sm text-emerald-300" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
        @csrf

        <div class="space-y-4">
            <div class="rounded-3xl border border-white/10 bg-white/5 px-4 py-3 shadow-[0_20px_70px_-60px_rgba(255,255,255,0.6)] backdrop-blur-sm">
                <label for="email" class="mb-2 inline-flex items-center gap-2 text-sm font-medium text-slate-300">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-amber-400/15 text-amber-200">✉️</span>
                    البريد الإلكتروني
                </label>
                <input id="email" class="mt-2 w-full rounded-[1.5rem] border border-slate-800 bg-slate-950/95 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-400/20" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="ادخل بريدك الإلكتروني" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-400" />
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 px-4 py-3 shadow-[0_20px_70px_-60px_rgba(255,255,255,0.6)] backdrop-blur-sm">
                <label for="password" class="mb-2 inline-flex items-center gap-2 text-sm font-medium text-slate-300">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-amber-400/15 text-amber-200">🔒</span>
                    كلمة المرور
                </label>
                <input id="password" class="mt-2 w-full rounded-[1.5rem] border border-slate-800 bg-slate-950/95 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-400/20" type="password" name="password" required autocomplete="current-password" placeholder="ادخل كلمة المرور" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-400" />
            </div>
        </div>

        <div class="flex items-center justify-between text-sm text-slate-400">
            <label for="remember_me" class="inline-flex items-center gap-3">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-700 bg-slate-900 text-amber-400 focus:ring-2 focus:ring-amber-400/50" name="remember">
                تذكرني
            </label>
            @if (Route::has('password.request'))
                <a class="text-amber-300 transition hover:text-amber-100" href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
            @endif
        </div>

        <button type="submit" class="w-full rounded-full bg-gradient-to-r from-amber-400 via-yellow-300 to-cyan-400 px-6 py-3 text-base font-semibold text-slate-950 shadow-[0_20px_50px_-20px_rgba(249,115,22,0.75)] transition hover:brightness-110">
            تسجيل الدخول
        </button>
    </form>
</x-guest-layout>
