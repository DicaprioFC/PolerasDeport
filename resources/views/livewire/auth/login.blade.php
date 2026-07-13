<div class="flex flex-col gap-6">
    <x-auth-header 
        :title="__('Log in to your account')" 
        :description="__('Enter your email and password below to log in')" 
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <!-- Error Google -->
    @if (session('error'))
        <div class="text-center text-sm text-red-600">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ __('Log in') }}
            </flux:button>
        </div>
    </form>

    <!-- Separador -->
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-zinc-300 dark:border-zinc-700"></div>
        </div>

        <div class="relative flex justify-center text-sm">
            <span class="bg-white px-2 text-zinc-500 dark:bg-zinc-900 dark:text-zinc-400">
                o continúa con
            </span>
        </div>
    </div>

    <!-- Botón Google -->
    <a href="{{ route('google.redirect') }}"
       class="w-full flex items-center justify-center gap-3 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">

        <svg class="h-5 w-5" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
            <path fill="#4285F4" d="M46.5 24.5c0-1.57-.14-3.08-.4-4.5H24v9h12.65c-.55 2.96-2.2 5.48-4.7 7.17l7.27 5.64C43.47 37.88 46.5 31.69 46.5 24.5z"/>
            <path fill="#FBBC05" d="M10.54 28.59c-.48-1.43-.76-2.95-.76-4.59s.27-3.16.76-4.59l-7.98-6.19C.93 16.46 0 20.12 0 24s.93 7.54 2.56 10.78l7.98-6.19z"/>
            <path fill="#34A853" d="M24 48c6.47 0 11.9-2.13 15.87-5.79l-7.27-5.64c-2.02 1.35-4.6 2.14-8.6 2.14-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
        </svg>

        Continuar con Google
    </a>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>