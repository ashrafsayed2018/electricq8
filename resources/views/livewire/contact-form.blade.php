@php $isAr = app()->getLocale() === 'ar'; @endphp

<div class="cf-root" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

{{-- ── Success state ─────────────────────────────────────────── --}}
@if($submitted)
<div class="cf-success">
    <div class="cf-success-icon">✅</div>
    <h2 class="cf-success-title">{{ $isAr ? 'تم الإرسال بنجاح!' : 'Message Sent!' }}</h2>
    <p class="cf-success-body">{{ __('site.contact.success') }}</p>
    <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="cf-wa-btn">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
        {{ $isAr ? 'تابعنا على واتساب' : 'Follow up on WhatsApp' }}
    </a>
</div>

{{-- ── Form state ────────────────────────────────────────────── --}}
@else

<div class="cf-header">
    <h2 class="cf-title">{{ __('site.contact.title') }}</h2>
    <p class="cf-subtitle">{{ $isAr ? 'أرسل طلبك وسنرد عليك خلال دقائق' : 'Send your request and we\'ll reply within minutes' }}</p>
</div>

<form wire:submit="send" class="cf-form" novalidate>

    {{-- Row: Name + Phone --}}
    <div class="cf-row">
        <div class="cf-field">
            <label class="cf-label" for="cf-name">
                {{ __('site.contact.name') }}
                <span class="cf-required">*</span>
            </label>
            <div class="cf-input-wrap {{ $errors->has('name') ? 'cf-input-wrap--error' : '' }}">
                <span class="cf-input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
                <input
                    id="cf-name"
                    wire:model="name"
                    type="text"
                    class="cf-input"
                    placeholder="{{ $isAr ? 'الاسم الكامل' : 'Your full name' }}"
                    autocomplete="name"
                >
            </div>
            @error('name') <p class="cf-error">{{ $message }}</p> @enderror
        </div>

        <div class="cf-field">
            <label class="cf-label" for="cf-phone">
                {{ __('site.contact.phone') }}
                <span class="cf-required">*</span>
            </label>
            <div class="cf-input-wrap {{ $errors->has('phone') ? 'cf-input-wrap--error' : '' }}">
                <span class="cf-input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </span>
                <input
                    id="cf-phone"
                    wire:model="phone"
                    type="tel"
                    class="cf-input"
                    placeholder="+965 XXXX XXXX"
                    autocomplete="tel"
                    dir="ltr"
                >
            </div>
            @error('phone') <p class="cf-error">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Row: Service + Area --}}
    <div class="cf-row">
        <div class="cf-field">
            <label class="cf-label" for="cf-service">{{ __('site.contact.service') }}</label>
            <div class="cf-input-wrap cf-select-wrap">
                <span class="cf-input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </span>
                <select id="cf-service" wire:model="service_id" class="cf-input cf-select">
                    <option value="">{{ $isAr ? '— اختر الخدمة —' : '— Select Service —' }}</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->getTranslation('title', app()->getLocale()) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="cf-field">
            <label class="cf-label" for="cf-area">{{ __('site.contact.area') }}</label>
            <div class="cf-input-wrap cf-select-wrap">
                <span class="cf-input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <select id="cf-area" wire:model="location_id" class="cf-input cf-select">
                    <option value="">{{ $isAr ? '— اختر المنطقة —' : '— Select Area —' }}</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->getTranslation('name', app()->getLocale()) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Message --}}
    <div class="cf-field">
        <label class="cf-label" for="cf-message">{{ __('site.contact.message') }}</label>
        <div class="cf-input-wrap cf-textarea-wrap">
            <textarea
                id="cf-message"
                wire:model="message"
                rows="4"
                class="cf-input cf-textarea"
                placeholder="{{ $isAr ? 'اكتب تفاصيل مشكلة الكهرباء أو طلبك هنا...' : 'Describe your AC problem or request here...' }}"
            ></textarea>
        </div>
        @error('message') <p class="cf-error">{{ $message }}</p> @enderror
    </div>

    {{-- Submit --}}
    <button type="submit" class="cf-submit-btn" wire:loading.attr="disabled" wire:loading.class="cf-submit-btn--loading">
        <span wire:loading.remove class="cf-submit-inner">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            {{ __('site.contact.send') }}
        </span>
        <span wire:loading class="cf-submit-inner">
            <svg class="cf-spin" width="18" height="18" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path d="M12 2a10 10 0 019.78 7.9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
            {{ $isAr ? 'جاري الإرسال...' : 'Sending...' }}
        </span>
    </button>

    {{-- Divider --}}
    <div class="cf-divider">
        <span>{{ $isAr ? 'أو تواصل مباشرة' : 'or contact directly' }}</span>
    </div>

    {{-- WhatsApp --}}
    <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="cf-wa-btn">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
        {{ $isAr ? 'تواصل عبر واتساب' : 'Contact via WhatsApp' }}
    </a>

</form>
@endif

</div>

<style>
/* ── root ───────────────────────────────────────────────────── */
.cf-root { font-family: 'Cairo', sans-serif; }

/* ── success ────────────────────────────────────────────────── */
.cf-success {
    text-align: center;
    padding: 32px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.cf-success-icon { font-size: 52px; line-height: 1; }
.cf-success-title { font-size: 1.5rem; font-weight: 800; color: var(--text); margin: 0; }
.cf-success-body  { color: var(--muted); font-size: 0.95rem; margin: 0; }

/* ── header ─────────────────────────────────────────────────── */
.cf-header { margin-bottom: 28px; }
.cf-title   { font-size: 1.6rem; font-weight: 800; color: var(--text); margin: 0 0 6px; }
.cf-subtitle{ font-size: 0.9rem; color: var(--muted); margin: 0; }

/* ── form layout ────────────────────────────────────────────── */
.cf-form  { display: flex; flex-direction: column; gap: 18px; }
.cf-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 520px) { .cf-row { grid-template-columns: 1fr; } }

/* ── field + label ──────────────────────────────────────────── */
.cf-field   { display: flex; flex-direction: column; gap: 6px; }
.cf-label   { font-size: 0.82rem; font-weight: 700; color: var(--text); letter-spacing: 0.01em; }
.cf-required{ color: #ef4444; margin-inline-start: 2px; }

/* ── input wrapper ──────────────────────────────────────────── */
.cf-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--altBg);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.cf-input-wrap:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--accentTint);
    background: var(--cardBg);
}
.cf-input-wrap--error { border-color: #ef4444 !important; }
.cf-input-wrap--error:focus-within { box-shadow: 0 0 0 3px rgba(239,68,68,0.15) !important; }

.cf-input-icon {
    padding-inline-start: 14px;
    color: var(--muted);
    display: flex;
    align-items: center;
    flex-shrink: 0;
}
.cf-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 12px 14px;
    font-size: 0.92rem;
    color: var(--text);
    font-family: 'Cairo', sans-serif;
    width: 100%;
}
.cf-input::placeholder { color: var(--muted); }

/* select — force correct colors in dark mode */
.cf-select-wrap .cf-select { appearance: none; cursor: pointer; color: var(--text); background: var(--altBg); }
.cf-select-wrap .cf-select option { background: var(--cardBg); color: var(--text); }
.cf-select-wrap::after {
    content: '';
    position: absolute;
    inset-inline-end: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid var(--muted);
    pointer-events: none;
}

/* textarea */
.cf-textarea-wrap { align-items: flex-start; }
.cf-textarea { resize: vertical; min-height: 100px; padding-top: 12px; }

/* error */
.cf-error { font-size: 0.78rem; color: #ef4444; margin: 0; }

/* ── submit button ──────────────────────────────────────────── */
.cf-submit-btn {
    width: 100%;
    background: linear-gradient(135deg, var(--primaryDk) 0%, var(--primary) 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 14px 24px;
    font-size: 1rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: opacity 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
    box-shadow: 0 4px 14px rgba(107,58,23,0.35);
}
.cf-submit-btn:hover:not([disabled]) {
    opacity: 0.92;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(107,58,23,0.45);
}
.cf-submit-btn:active:not([disabled]) { transform: translateY(0); }
.cf-submit-btn[disabled], .cf-submit-btn--loading { opacity: 0.7; cursor: not-allowed; }
.cf-submit-inner { display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
@keyframes cf-spin { to { transform: rotate(360deg); } }
.cf-spin { animation: cf-spin 0.8s linear infinite; }

/* ── divider ────────────────────────────────────────────────── */
.cf-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--muted);
    font-size: 0.8rem;
}
.cf-divider::before, .cf-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

/* ── WhatsApp button ────────────────────────────────────────── */
.cf-wa-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #25d366;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    padding: 13px 24px;
    font-size: 0.95rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    transition: background 0.2s ease, transform 0.15s ease;
    box-shadow: 0 4px 14px rgba(37,211,102,0.3);
}
.cf-wa-btn:hover {
    background: #128c4e;
    transform: translateY(-1px);
}
</style>
