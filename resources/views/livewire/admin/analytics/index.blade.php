<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.analytics.title') }}</h1>

        {{-- Range picker --}}
        <div class="flex items-center gap-2 flex-wrap">
            @foreach($this->ranges as $key => $labels)
                <button wire:click="$set('range', '{{ $key }}')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition
                           {{ $range === $key ? 'bg-purple-600 text-white' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10' }}">
                    {{ $labels['ar'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Custom date range --}}
    @if($range === 'custom')
        <div class="flex items-center gap-3 mb-6">
            <input wire:model.live="dateFrom" type="date"
                class="bg-[#1a1d27] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500">
            <span class="text-gray-500 text-sm">—</span>
            <input wire:model.live="dateTo" type="date"
                class="bg-[#1a1d27] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500">
        </div>
    @endif

    {{-- KPI card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-5">
            <p class="text-xs text-gray-500 mb-1">{{ __('admin.analytics.total_conversions') }}</p>
            <p class="text-3xl font-bold text-white">{{ number_format($this->overview['totalConversions']) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- By page type --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.analytics.by_page') }}</h2>
            @forelse($this->overview['conversionsByPage'] as $row)
                <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                    <span class="text-sm text-gray-300">{{ $row['label'] }}</span>
                    <span class="text-sm font-semibold text-white">{{ number_format($row['total']) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-600">{{ __('admin.analytics.no_data') }}</p>
            @endforelse
        </div>

        {{-- By locale --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.analytics.by_language') }}</h2>
            @forelse($this->overview['conversionsByLocale'] as $row)
                <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                    <span class="text-sm text-gray-300">{{ $row['label'] }}</span>
                    <span class="text-sm font-semibold text-white">{{ number_format($row['total']) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-600">{{ __('admin.analytics.no_data') }}</p>
            @endforelse
        </div>

        {{-- By source --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.analytics.by_source') }}</h2>
            @forelse($this->overview['conversionsBySource'] as $row)
                <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                    <span class="text-sm text-gray-300 dir-ltr">{{ $row['label'] }}</span>
                    <span class="text-sm font-semibold text-white">{{ number_format($row['total']) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-600">{{ __('admin.analytics.no_data') }}</p>
            @endforelse
        </div>

        {{-- Assisted content --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.analytics.assisted') }}</h2>
            @forelse($this->overview['assistedConversionsByContent'] as $row)
                <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                    <span class="text-sm text-gray-300">{{ $row['label'] }}</span>
                    <span class="text-sm font-semibold text-white">{{ number_format($row['total']) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-600">{{ __('admin.analytics.no_data') }}</p>
            @endforelse
        </div>

    </div>
</div>
