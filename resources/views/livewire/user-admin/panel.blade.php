<div>
    <span>Content</span>



    <div class="custom-select-wrapper">
        <select id="my-select" multiple style="display: none;">
{{--            <option value="option1">گزینه یک</option>--}}
{{--            <option value="option2">گزینه دو</option>--}}
{{--            <option value="option3">گزینه سه</option>--}}
{{--            <option value="option4">گزینه چهار</option>--}}
{{--            <option value="option5">گزینه پنج</option>--}}
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <div class="custom-select-ui">
            <div class="input-container">
                <div class="selected-tags-container"></div>
                <input type="text" id="search-input" class="search-input" placeholder="انتخاب آیتم یا جستجو...">
            </div>

            <div class="toggle-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
            </div>
        </div>

        <div class="options-container">
        </div>
    </div>
    <livewire:components.forms.searchable-select />
</div>
