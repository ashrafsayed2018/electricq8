<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site.auth.register_title') }} — ElectricQ8</title>
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --bg:#FAF6F1;--cardBg:#FFFFFF;--border:#E7DCCC;--text:#2B211A;
            --muted:#7A6A5C;--primary:#6B3A17;--primaryText:#6B3A17;--accent:#D97B2E;--accentTint:#F3D9BB;
        }
        @media(prefers-color-scheme:dark){
            :root{--bg:#1C140D;--cardBg:#2C2013;--border:#4A3826;--text:#F3E9DC;--muted:#C4AD95;--primaryText:#E3A15E;}
        }
        :root[data-theme="light"]{--bg:#FAF6F1;--cardBg:#FFFFFF;--border:#E7DCCC;--text:#2B211A;--muted:#7A6A5C;--primaryText:#6B3A17;}
        :root[data-theme="dark"]{--bg:#1C140D;--cardBg:#2C2013;--border:#4A3826;--text:#F3E9DC;--muted:#C4AD95;--primaryText:#E3A15E;}

        *,*::before,*::after{box-sizing:border-box}
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;
             background:var(--bg);font-family:'Cairo',system-ui,sans-serif;padding:20px}

        .rc{background:var(--cardBg);border:1px solid var(--border);border-radius:20px;
            padding:36px 32px;width:100%;max-width:420px;box-shadow:0 4px 24px rgba(43,33,26,.08)}
        .rc__brand{text-align:center;margin-bottom:28px}
        .rc__logo{font-size:1.5rem;font-weight:900;color:var(--primary);letter-spacing:-.5px;display:block;margin-bottom:4px}
        .rc__sub{font-size:.8rem;color:var(--muted)}
        .rc__error{background:#FEF2F2;border:1px solid #FECACA;color:#B91C1C;border-radius:10px;
                   padding:10px 14px;margin-bottom:20px;font-size:.83rem}
        .rc__field{margin-bottom:16px}
        .rc__label{display:block;font-size:.82rem;font-weight:700;color:var(--text);margin-bottom:5px}
        .rc__input{width:100%;border:1px solid var(--border);border-radius:10px;padding:11px 14px;
                   font-size:.88rem;color:var(--text);background:var(--bg);outline:none;
                   transition:border-color .2s,box-shadow .2s;font-family:inherit}
        .rc__input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(107,58,23,.12)}
        .rc__input--error{border-color:#EF4444}
        .rc__err{font-size:.75rem;color:#EF4444;margin:4px 0 0}
        .rc__pw-wrap{position:relative}
        .rc__pw-toggle{position:absolute;inset-block:0;display:flex;align-items:center;color:var(--muted);
                       background:none;border:none;cursor:pointer;padding:0 12px;inset-inline-end:0}
        .rc__pw-toggle:hover{color:var(--text)}
        .rc__submit{width:100%;background:var(--primary);color:#fff;font-weight:800;font-size:.9rem;
                    border:none;border-radius:12px;padding:13px;cursor:pointer;transition:opacity .2s;
                    font-family:inherit;margin-top:4px}
        .rc__submit:hover{opacity:.88}
        .rc__footer{text-align:center;font-size:.8rem;color:var(--muted);margin-top:20px}
        .rc__footer a{color:var(--primary);font-weight:700;text-decoration:none}
        .rc__footer a:hover{text-decoration:underline}
    </style>
    <script>
    (function(){
        var s=localStorage.getItem('eq8-theme');
        if(s){document.documentElement.setAttribute('data-theme',s);return;}
        if(window.matchMedia('(prefers-color-scheme:dark)').matches){document.documentElement.setAttribute('data-theme','dark');}
    })();
    </script>
</head>
<body>

    <div class="rc">
        <div class="rc__brand">
            <span class="rc__logo">ElectricQ8</span>
            <span class="rc__sub">{{ __('site.auth.register_subtitle') }}</span>
        </div>

        @if($errors->any())
            <div class="rc__error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="rc__field">
                <label class="rc__label" for="rc-name">{{ __('site.auth.name') }}</label>
                <input id="rc-name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="rc__input{{ $errors->has('name') ? ' rc__input--error' : '' }}"
                    autocomplete="name">
                @error('name') <p class="rc__err">{{ $message }}</p> @enderror
            </div>

            <div class="rc__field">
                <label class="rc__label" for="rc-email">{{ __('site.auth.email') }}</label>
                <input id="rc-email" type="email" name="email" value="{{ old('email') }}" required
                    class="rc__input{{ $errors->has('email') ? ' rc__input--error' : '' }}"
                    autocomplete="email">
                @error('email') <p class="rc__err">{{ $message }}</p> @enderror
            </div>

            <div class="rc__field">
                <label class="rc__label" for="rc-password">{{ __('site.auth.password') }}</label>
                <div class="rc__pw-wrap">
                    <input id="rc-password" type="password" name="password" required
                        class="rc__input{{ $errors->has('password') ? ' rc__input--error' : '' }}"
                        autocomplete="new-password"
                        style="padding-inline-end:42px">
                    <button type="button" class="rc__pw-toggle" onclick="rcTogglePw('rc-password','eye-pw')" aria-label="show/hide">
                        <svg id="eye-pw" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password') <p class="rc__err">{{ $message }}</p> @enderror
            </div>

            <div class="rc__field">
                <label class="rc__label" for="rc-password-confirm">{{ __('site.auth.confirm_password') }}</label>
                <div class="rc__pw-wrap">
                    <input id="rc-password-confirm" type="password" name="password_confirmation" required
                        class="rc__input"
                        autocomplete="new-password"
                        style="padding-inline-end:42px">
                    <button type="button" class="rc__pw-toggle" onclick="rcTogglePw('rc-password-confirm','eye-confirm')" aria-label="show/hide">
                        <svg id="eye-confirm" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="rc__submit">
                {{ __('site.auth.create_account') }}
            </button>
        </form>

        <p class="rc__footer">
            {{ __('site.auth.have_account') }}
            <a href="{{ route('login') }}">{{ __('site.auth.login_link') }}</a>
        </p>
    </div>

    <script>
    function rcTogglePw(inputId, eyeId) {
        var input = document.getElementById(inputId);
        var eye   = document.getElementById(eyeId);
        var show  = input.type === 'password';
        input.type = show ? 'text' : 'password';
        eye.innerHTML = show
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.34 6.34A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.357 2.572M6.34 6.34L3 3m3.34 3.34l11.32 11.32M16.66 16.66L20 20"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
    </script>

</body>
</html>
