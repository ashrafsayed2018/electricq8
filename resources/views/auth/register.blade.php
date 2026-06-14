<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site.auth.register_title') }} — ElectricQ8</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-yellow-700">ElectricQ8</h1>
            <p class="text-gray-500 text-sm mt-1">{{ __('site.auth.register_subtitle') }}</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.auth.name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500
                           @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.auth.email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500
                           @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.auth.password') }}</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500
                               @error('password') border-red-500 @enderror">
                    <button type="button" onclick="togglePassword('password', 'eye-password')"
                        class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} flex items-center text-gray-400 hover:text-gray-600">
                        <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                   -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.auth.confirm_password') }}</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-confirm')"
                        class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} flex items-center text-gray-400 hover:text-gray-600">
                        <svg id="eye-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                   -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 rounded-xl transition">
                {{ __('site.auth.create_account') }}
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            {{ __('site.auth.have_account') }}
            <a href="{{ route('login') }}" class="text-yellow-600 hover:underline font-medium">
                {{ __('site.auth.login_link') }}
            </a>
        </p>
    </div>

    <script>
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye   = document.getElementById(eyeId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            eye.innerHTML = isHidden
                ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
                          a9.956 9.956 0 012.293-3.95M6.34 6.34A9.956 9.956 0 0112 5
                          c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.357 2.572
                          M6.34 6.34L3 3m3.34 3.34l11.32 11.32M16.66 16.66L20 20" />`
                : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                          -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    </script>

</body>
</html>
