import './bootstrap';


document.addEventListener('DOMContentLoaded', () => {
    const customSelectWrapper = document.querySelector('.custom-select-wrapper');
    const select = document.getElementById('my-select');
    const optionsContainer = document.querySelector('.options-container');
    const tagsContainer = document.querySelector('.selected-tags-container');
    const searchInput = document.getElementById('search-input');
    const toggleButton = document.querySelector('.toggle-button');
    const inputContainer = document.querySelector('.input-container');

    // ساخت گزینه‌ها در ظاهر سفارشی
    Array.from(select.options).forEach(option => {
        const optionItem = document.createElement('div');
        optionItem.className = 'option-item';
        optionItem.textContent = option.textContent;
        optionItem.dataset.value = option.value;
        optionsContainer.appendChild(optionItem);
    });

    // باز کردن لیست گزینه‌ها با کلیک روی هر بخش از فیلد
    inputContainer.addEventListener('click', () => {
        optionsContainer.style.display = 'block';
        searchInput.focus(); // تمرکز روی فیلد جستجو
    });

    // مدیریت انتخاب گزینه‌ها
    optionsContainer.addEventListener('click', (e) => {
        const target = e.target.closest('.option-item');
        if (target) {
            const value = target.dataset.value;
            const option = select.querySelector(`option[value="${value}"]`);

            if (option.selected) {
                option.selected = false;
                target.classList.remove('selected');
                document.querySelector(`.selected-tag[data-value="${value}"]`).remove();
            } else {
                option.selected = true;
                target.classList.add('selected');

                const tag = document.createElement('span');
                tag.className = 'selected-tag';
                tag.textContent = option.textContent;
                tag.dataset.value = value;
                tag.innerHTML += `<span class="remove-tag">×</span>`;
                tagsContainer.appendChild(tag);
            }
            searchInput.value = ''; // پاک کردن فیلد جستجو
            filterOptions(''); // نمایش مجدد همه گزینه‌ها
            searchInput.focus(); // حفظ تمرکز برای ادامه جستجو
        }
    });

    // مدیریت حذف تگ‌ها
    tagsContainer.addEventListener('click', (e) => {
        const removeButton = e.target.closest('.remove-tag');
        if (removeButton) {
            const tag = removeButton.closest('.selected-tag');
            const value = tag.dataset.value;
            select.querySelector(`option[value="${value}"]`).selected = false;
            document.querySelector(`.option-item[data-value="${value}"]`).classList.remove('selected');
            tag.remove();
        }
    });

    // پنهان کردن لیست با کلیک بیرون از آن
    document.addEventListener('click', (e) => {
        if (!customSelectWrapper.contains(e.target)) {
            optionsContainer.style.display = 'none';
        }
    });

    // تابع فیلتر کردن گزینه‌ها
    function filterOptions(searchTerm) {
        const optionItems = optionsContainer.querySelectorAll('.option-item');
        optionItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // قابلیت جستجو در زمان تایپ
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        filterOptions(searchTerm);
    });
});
