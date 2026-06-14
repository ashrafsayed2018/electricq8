<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">{{ __('admin.posts.title') }}</h1>
            <p class="text-gray-500 text-xs mt-0.5">{{ __('admin.posts.subtitle') }}</p>
        </div>
        @can('posts.create')
        <a href="{{ route('admin.posts.create') }}"
           class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('admin.posts.add') }}
        </a>
        @endcan
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-3">
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-purple-500/15 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-bold text-white">{{ $totalCount }}</p>
                <p class="text-xs text-gray-500">{{ __('admin.posts.total') }}</p>
            </div>
        </div>
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-green-500/15 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-bold text-white">{{ $publishedCount }}</p>
                <p class="text-xs text-gray-500">{{ __('admin.posts.published') }}</p>
            </div>
        </div>
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-yellow-500/15 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-bold text-white">{{ $draftCount }}</p>
                <p class="text-xs text-gray-500">{{ __('admin.posts.draft') }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar: filters + search --}}
    <div class="flex items-center gap-3 flex-wrap">
        <div class="flex bg-[#1a1d27] rounded-lg border border-white/10 p-0.5 gap-0.5">
            <button wire:click="$set('status', '')"
                class="px-3 py-1.5 rounded-md text-xs font-semibold transition
                       {{ $status === '' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white' }}">
                {{ __('admin.posts.all') }} ({{ $totalCount }})
            </button>
            <button wire:click="$set('status', 'published')"
                class="px-3 py-1.5 rounded-md text-xs font-semibold transition
                       {{ $status === 'published' ? 'bg-green-600 text-white' : 'text-gray-400 hover:text-white' }}">
                {{ __('admin.posts.published') }} ({{ $publishedCount }})
            </button>
            <button wire:click="$set('status', 'draft')"
                class="px-3 py-1.5 rounded-md text-xs font-semibold transition
                       {{ $status === 'draft' ? 'bg-yellow-600 text-white' : 'text-gray-400 hover:text-white' }}">
                {{ __('admin.posts.draft') }} ({{ $draftCount }})
            </button>
        </div>

        <div class="relative flex-1 min-w-48">
            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none"
                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="{{ __('admin.posts.search') }}"
                   class="w-full bg-[#1a1d27] border border-white/10 rounded-lg pr-9 pl-9 py-2 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 transition">
            @if($search)
                <button wire:click="$set('search', '')"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-right w-12"></th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.title_ar') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.status') }}</th>
                    <th class="px-4 py-3 text-right hidden md:table-cell">{{ __('admin.posts.publish_date') }}</th>
                    <th class="px-4 py-3 text-right hidden lg:table-cell">{{ __('admin.posts.sort_order') }}</th>
                    @role('admin')
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                    @endrole
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($posts as $post)
                    <tr class="hover:bg-white/3 transition">

                        {{-- Thumbnail --}}
                        <td class="px-4 py-3">
                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-[#0f1117] border border-white/10 shrink-0">
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Title --}}
                        <td class="px-4 py-3 max-w-xs">
                            <p class="text-white font-semibold text-sm truncate">
                                {{ $post->getTranslation('title', 'ar') }}
                            </p>
                            <p class="text-gray-500 text-xs truncate mt-0.5">
                                {{ $post->getTranslation('title', 'en') }}
                            </p>
                            @if($post->getTranslation('excerpt', 'ar'))
                                <p class="text-gray-600 text-xs mt-1 truncate max-w-sm">
                                    {{ Str::limit(strip_tags($post->getTranslation('excerpt', 'ar')), 60) }}
                                </p>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full
                                {{ $post->status->value === 'published'
                                    ? 'bg-green-500/15 text-green-400'
                                    : 'bg-yellow-500/15 text-yellow-400' }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $post->status->value === 'published' ? 'bg-green-400' : 'bg-yellow-400' }}">
                                </span>
                                {{ $post->status->value === 'published' ? __('admin.posts.published') : __('admin.posts.draft') }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="px-4 py-3 hidden md:table-cell">
                            @if($post->published_at)
                                <span class="text-gray-400 text-xs">
                                    {{ $post->published_at->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-gray-700 text-xs">—</span>
                            @endif
                        </td>

                        {{-- Sort --}}
                        <td class="px-4 py-3 hidden lg:table-cell">
                            <span class="text-gray-600 text-xs font-mono">#{{ $post->sort_order }}</span>
                        </td>

                        {{-- Actions --}}
                        @role('admin')
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                   class="inline-flex items-center gap-1.5 bg-purple-600/15 hover:bg-purple-600 text-purple-400 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    {{ __('admin.common.edit') }}
                                </a>
                                <button wire:click="delete({{ $post->id }})"
                                        wire:confirm="{{ __('admin.posts.confirm_delete') }}"
                                        class="inline-flex items-center gap-1.5 bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('admin.common.delete') }}
                                </button>
                            </div>
                        </td>
                        @endrole

                        {{-- Writer: edit only --}}
                        @hasanyrole('writer')
                        @can('posts.edit')
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.posts.edit', $post) }}"
                               class="inline-flex items-center gap-1.5 bg-purple-600/15 hover:bg-purple-600 text-purple-400 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ __('admin.common.edit') }}
                            </a>
                        </td>
                        @endcan
                        @endhasanyrole

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">
                                    {{ $search ? __('admin.posts.no_results', ['search' => $search]) : __('admin.posts.empty') }}
                                </p>
                                @if($search)
                                    <button wire:click="$set('search', '')" class="text-purple-400 hover:text-purple-300 text-xs transition">
                                        {{ __('admin.posts.clear_search') }}
                                    </button>
                                @else
                                    @can('posts.create')
                                    <a href="{{ route('admin.posts.create') }}" class="text-purple-400 hover:text-purple-300 text-xs transition">
                                        {{ __('admin.posts.add_first') }}
                                    </a>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($posts->hasPages())
            <div class="px-4 py-3 border-t border-white/10">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</div>
