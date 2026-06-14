<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-white">
                {{ $serviceLocationPage ? 'تعديل صفحة' : 'إضافة صفحة خدمة × منطقة' }}
            </h1>
            @if($serviceLocationPage)
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $serviceLocationPage->getTranslation('title', 'ar') }}
            </p>
            @endif
        </div>
        <a href="{{ route('admin.service-locations.index') }}"
           class="text-sm text-gray-400 hover:text-white transition flex items-center gap-1.5">
            ← العودة للقائمة
        </a>
    </div>

    <form wire:submit="save" class="space-y-5 max-w-4xl">

        {{-- Service + Location selectors --}}
        <div class="bg-[#1a1d27] rounded-2xl border border-white/8 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">الخدمة والمنطقة</h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1.5">الخدمة</label>
                    <select wire:model="service_id"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                        <option value="0">— اختر خدمة —</option>
                        @foreach($services as $s)
                        <option value="{{ $s->id }}">{{ $s->getTranslation('title', 'ar') }}</option>
                        @endforeach
                    </select>
                    @error('service_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1.5">المنطقة</label>
                    <select wire:model="location_id"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                        <option value="0">— اختر منطقة —</option>
                        @foreach($locations as $l)
                        <option value="{{ $l->id }}">{{ $l->getTranslation('name', 'ar') }}</option>
                        @endforeach
                    </select>
                    @error('location_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <button type="button" wire:click="autoFill"
                class="flex items-center gap-2 text-sm text-purple-400 hover:text-purple-300 transition font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                تعبئة تلقائية من الاسم
            </button>
        </div>

        {{-- Title + H1 --}}
        <div class="bg-[#1a1d27] rounded-2xl border border-white/8 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">العنوان وH1</h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach([['title','عنوان الصفحة'],['h1','H1 — العنوان الرئيسي']] as [$field,$label])
                <div>
                    <label class="block text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded bg-white/10 text-center text-gray-400 text-[10px] font-bold leading-4">ع</span>
                        {{ $label }} (عربي)
                    </label>
                    <input wire:model="{{ $field }}_ar" type="text"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    @error($field . '_ar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded bg-white/10 text-center text-gray-400 text-[10px] font-bold leading-4">A</span>
                        {{ $label }} (English)
                    </label>
                    <input wire:model="{{ $field }}_en" type="text" dir="ltr"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Meta SEO --}}
        <div class="bg-[#1a1d27] rounded-2xl border border-white/8 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">SEO Meta</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">Meta Title (عربي)</label>
                        <input wire:model="meta_title_ar" type="text"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">Meta Title (English)</label>
                        <input wire:model="meta_title_en" type="text" dir="ltr"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">Meta Description (عربي)</label>
                        <textarea wire:model="meta_description_ar" rows="2"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">Meta Description (English)</label>
                        <textarea wire:model="meta_description_en" rows="2" dir="ltr"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Unique local content --}}
        <div class="bg-[#1a1d27] rounded-2xl border border-white/8 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">المحتوى المحلي الفريد</h2>
            <p class="text-xs text-gray-600 mb-4">هذا المحتوى هو سر تميّز الصفحة — اجعل كل منطقة مختلفة عن الأخرى</p>
            <div class="space-y-4">
                @foreach([
                    ['intro','مقدمة الصفحة'],
                    ['local_problem','المشكلة المحلية'],
                    ['local_solution','الحل المقدَّم'],
                    ['cta_text','نص زر الطلب'],
                ] as [$field, $label])
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">{{ $label }} (عربي)</label>
                        <textarea wire:model="{{ $field }}_ar" rows="3"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">{{ $label }} (English)</label>
                        <textarea wire:model="{{ $field }}_en" rows="3" dir="ltr"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    </div>
                </div>
                @endforeach

                {{-- Rich content --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">محتوى تفصيلي HTML (عربي)</label>
                        <textarea wire:model="unique_local_content_ar" rows="6"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white font-mono focus:outline-none focus:border-purple-500 transition resize-y"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">Rich Content HTML (English)</label>
                        <textarea wire:model="unique_local_content_en" rows="6" dir="ltr"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white font-mono focus:outline-none focus:border-purple-500 transition resize-y"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status + noindex --}}
        <div class="bg-[#1a1d27] rounded-2xl border border-white/8 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">الحالة والنشر</h2>
            <div class="flex items-center gap-6">
                <div>
                    <label class="block text-xs text-gray-500 mb-1.5">الحالة</label>
                    <select wire:model="status"
                        class="bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                        <option value="active">نشطة</option>
                        <option value="inactive">موقوفة</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 mt-4">
                    <input wire:model="noindex" type="checkbox" id="noindex"
                        class="w-4 h-4 rounded border-white/20 bg-[#0f1117] accent-purple-500">
                    <label for="noindex" class="text-sm text-gray-400">
                        noindex
                        <span class="text-gray-600 text-xs">(محتوى رقيق — لا تفهرسه جوجل بعد)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-purple-600 hover:bg-purple-500 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition">
                {{ $serviceLocationPage ? 'حفظ التعديلات' : 'إنشاء الصفحة' }}
            </button>
            <a href="{{ route('admin.service-locations.index') }}"
               class="bg-white/5 hover:bg-white/10 text-gray-400 px-6 py-2.5 rounded-xl font-semibold text-sm transition">
                إلغاء
            </a>
        </div>

    </form>
</div>
