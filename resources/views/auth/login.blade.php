<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site.auth.login_title') }} — ElectricQ8</title>
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --bg:#FAF6F1;--cardBg:#FFFFFF;--border:#E7DCCC;--text:#2B211A;
            --muted:#7A6A5C;--primary:#6B3A17;--accent:#D97B2E;--accentTint:#F3D9BB;
        }
        @media(prefers-color-scheme:dark){
            :root{--bg:#1C140D;--cardBg:#2C2013;--border:#4A3826;--text:#F3E9DC;--muted:#C4AD95;}
        }
        :root[data-theme="light"]{--bg:#FAF6F1;--cardBg:#FFFFFF;--border:#E7DCCC;--text:#2B211A;--muted:#7A6A5C;}
        :root[data-theme="dark"]{--bg:#1C140D;--cardBg:#2C2013;--border:#4A3826;--text:#F3E9DC;--muted:#C4AD95;}

        *,*::before,*::after{box-sizing:border-box}
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;
             background:var(--bg);font-family:'Cairo',system-ui,sans-serif;padding:20px}

        .lc{background:var(--cardBg);border:1px solid var(--border);border-radius:20px;
            padding:36px 32px;width:100%;max-width:420px;box-shadow:0 4px 24px rgba(43,33,26,.08)}
        .lc__brand{text-align:center;margin-bottom:28px}
        .lc__logo{font-size:1.5rem;font-weight:900;color:var(--primary);letter-spacing:-.5px;display:block;margin-bottom:4px}
        .lc__sub{font-size:.8rem;color:var(--muted)}
        .lc__error{background:#FEF2F2;border:1px solid #FECACA;color:#B91C1C;border-radius:10px;
                   padding:10px 14px;margin-bottom:20px;font-size:.83rem}
        .lc__label{display:block;font-size:.82rem;font-weight:700;color:var(--text);margin-bottom:5px}
        .lc__input{width:100%;border:1px solid var(--border);border-radius:10px;padding:11px 14px;
                   font-size:.88rem;color:var(--text);background:var(--bg);outline:none;
                   transition:border-color .2s,box-shadow .2s;font-family:inherit}
        .lc__input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(107,58,23,.12)}
        .lc__input--error{border-color:#EF4444}
        .lc__err{font-size:.75rem;color:#EF4444;margin:4px 0 0}
        .lc__field{margin-bottom:16px}
        .lc__pw-wrap{position:relative}
        .lc__pw-toggle{position:absolute;inset-block:0;display:flex;align-items:center;color:var(--muted);
                       background:none;border:none;cursor:pointer;padding:0 12px;
                       inset-inline-end:0}
        .lc__pw-toggle:hover{color:var(--text)}
        .lc__remember{display:flex;align-items:center;gap:8px;font-size:.83rem;color:var(--muted);margin-bottom:20px}
        .lc__remember input{accent-color:var(--primary);width:15px;height:15px}
        .lc__submit{width:100%;background:var(--primary);color:#fff;font-weight:800;font-size:.9rem;
                    border:none;border-radius:12px;padding:13px;cursor:pointer;transition:opacity .2s;
                    font-family:inherit}
        .lc__submit:hover{opacity:.88}
        .lc__footer{text-align:center;font-size:.8rem;color:var(--muted);margin-top:20px}
        .lc__footer a{color:var(--primary);font-weight:700;text-decoration:none}
        .lc__footer a:hover{text-decoration:underline}
    </style>
</head>
<body>

    <div class="lc">
        <div class="lc__brand">
            <span class="lc__logo">ElectricQ8</span>
            <span class="lc__sub">{{ __('site.auth.login_subtitle') }}</span>
        </div>

        @if($errors->any())
            <div class="lc__error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="lc__field">
                <label class="lc__label">{{ __('site.auth.email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="lc__input {{ $errors->has('email') ? 'lc__input--error' : '' }}">
                @error('email')<p class="lc__err">{{ $message }}</p>@enderror
            </div>

            <div class="lc__field">
                <label class="lc__label">{{ __('site.auth.password') }}</label>
                <div class="lc__pw-wrap">
                    <input type="password" name="password" id="password" required
                        class="lc__input {{ $errors->has('password') ? 'lc__input--error' : '' }}"
                        style="padding-inline-end:44px">
                    <button type="button" class="lc__pw-toggle" onclick="togglePassword('password','eye-pw')">
                        <svg id="eye-pw" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')<p class="lc__err">{{ $message }}</p>@enderror
            </div>

            <div class="lc__remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">{{ __('site.auth.remember') }}</label>
            </div>

            <button type="submit" class="lc__submit">{{ __('site.auth.sign_in') }}</button>
        </form>

        <p class="lc__footer">
            {{ __('site.auth.no_account') }}
            <a href="{{ route('register') }}">{{ __('site.auth.register_link') }}</a>
        </p>
    </div>

    <script>
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye   = document.getElementById(eyeId);
            const hide = input.type === 'password';
            input.type = hide ? 'text' : 'password';
            eye.innerHTML = hide
                ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.34 6.34A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.357 2.572M6.34 6.34L3 3m3.34 3.34l11.32 11.32M16.66 16.66L20 20"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    </script>

</body>
</html>
