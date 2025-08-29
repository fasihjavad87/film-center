<div x-data="{ open: false }" class="relative w-72">
    <!-- input برای سرچ -->
    <input type="text"
           wire:model="search"
           @focus="open = true"
           placeholder="جستجوی دسته بندی..."
           class="w-full border rounded-lg p-2" />

    <!-- لیست نتایج -->
    <div x-show="open" @click.away="open = false"
         class="absolute w-full bg-white border rounded-lg mt-1 max-h-48 overflow-y-auto z-10">
        @forelse($categories as $category)
            <div wire:click="toggleCategory({{ $category['id'] }})"
                 class="p-2 cursor-pointer hover:bg-gray-100 flex justify-between">
                <span>{{ $category['name'] }}</span>
                @if(in_array($category['id'], $selected))
                    ✅
                @endif
            </div>
        @empty
            <div class="p-2 text-gray-500">موردی یافت نشد</div>
        @endforelse
    </div>

    <!-- انتخاب‌شده‌ها -->
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach($selected as $id)
            @php $cat = \App\Models\Category::find($id); @endphp
            <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-lg text-sm">
                {{ $cat->name }}
            </span>
        @endforeach
    </div>

    <!-- مقدار نهایی (برای فرم) -->
    <input type="hidden" name="categories" value="{{ implode(',', $selected) }}">
</div>
