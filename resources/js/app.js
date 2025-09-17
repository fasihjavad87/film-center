import './bootstrap';
import 'preline'

// document.addEventListener('DOMContentLoaded', () => {
//     // پیدا کردن تمام کامپوننت‌ها با کلاس .custom-select-wrapper
//     const allCustomSelects = document.querySelectorAll('.custom-select-wrapper');
//
//     allCustomSelects.forEach(customSelectWrapper => {
//         const select = customSelectWrapper.querySelector('select');
//         const optionsContainer = customSelectWrapper.querySelector('.options-container');
//         const tagsContainer = customSelectWrapper.querySelector('.selected-tags-container');
//         const searchInput = customSelectWrapper.querySelector('.search-input');
//         const toggleButton = customSelectWrapper.querySelector('.toggle-button');
//         const wireModelName = customSelectWrapper.dataset.model;
//
//         // ساخت گزینه‌ها در ظاهر سفارشی
//         Array.from(select.options).forEach(option => {
//             const optionItem = document.createElement('div');
//             optionItem.className = 'option-item';
//             optionItem.textContent = option.textContent;
//             optionItem.dataset.value = option.value;
//
//             if (option.selected) {
//                 optionItem.classList.add('selected');
//
//                 const tag = document.createElement('span');
//                 tag.className = 'selected-tag';
//                 tag.dataset.value = option.value;
//
//                 const textSpan = document.createElement('span');
//                 textSpan.textContent = option.textContent;
//                 tag.appendChild(textSpan);
//
//                 const removeIcon = document.createElement('i');
//                 removeIcon.className = 'remove-tag fa-regular fa-xmark';
//                 tag.appendChild(removeIcon);
//
//                 tagsContainer.appendChild(tag);
//             }
//
//             optionsContainer.appendChild(optionItem);
//         });
//
//         // باز کردن لیست گزینه‌ها
//         customSelectWrapper.addEventListener('click', (e) => {
//             if (!e.target.closest('.remove-tag')) {
//                 optionsContainer.style.display = 'flex';
//                 searchInput.focus();
//                 customSelectWrapper.classList.add('open');
//             }
//         });
//
//         // ... بقیه کدهای مربوط به این کامپوننت را در اینجا قرار دهید ...
//
//         // مدیریت انتخاب گزینه‌ها
//         optionsContainer.addEventListener('click', (e) => {
//             const target = e.target.closest('.option-item');
//             if (target) {
//                 const value = target.dataset.value;
//                 const option = select.querySelector(`option[value="${value}"]`);
//
//                 if (!option.selected) {
//                     option.selected = true;
//                     target.classList.add('selected');
//
//                     const tag = document.createElement('span');
//                     tag.className = 'selected-tag';
//                     tag.dataset.value = value;
//
//                     const textSpan = document.createElement('span');
//                     textSpan.textContent = option.textContent;
//                     tag.appendChild(textSpan);
//
//                     const removeIcon = document.createElement('i');
//                     removeIcon.className = 'remove-tag fa-regular fa-xmark';
//                     tag.appendChild(removeIcon);
//
//                     tagsContainer.appendChild(tag);
//                 } else {
//                     option.selected = false;
//                     target.classList.remove('selected');
//                     customSelectWrapper.querySelector(`.selected-tag[data-value="${value}"]`).remove();
//                 }
//                 updateLivewireValue(customSelectWrapper, wireModelName);
//                 searchInput.value = '';
//                 filterOptions('');
//                 searchInput.focus();
//             }
//         });
//
//         // مدیریت حذف تگ‌ها
//         tagsContainer.addEventListener('click', (e) => {
//             const removeButton = e.target.closest('.remove-tag');
//             if (removeButton) {
//                 const tag = removeButton.closest('.selected-tag');
//                 const value = tag.dataset.value;
//                 select.querySelector(`option[value="${value}"]`).selected = false;
//                 customSelectWrapper.querySelector(`.option-item[data-value="${value}"]`).classList.remove('selected');
//                 tag.remove();
//                 updateLivewireValue(customSelectWrapper, wireModelName);
//             }
//         });
//
//         function updateLivewireValue(wrapper, modelName) {
//             const selectedValues = Array.from(wrapper.querySelectorAll('option:checked')).map(o => o.value);
//
//             const compEl = wrapper.closest('[wire\\:id]');
//             if (!compEl) return;
//
//             const comp = Livewire.find(compEl.getAttribute('wire:id'));
//
//             // فقط روی property مدل‌ـبلِ فرزند ست کن
//             if (modelName === 'release_year') {
//                 comp.set('value', selectedValues.length ? parseInt(selectedValues[0], 10) : null);
//             } else {
//                 comp.set('value', selectedValues);
//             }
//         }
//
//
//
//         // پنهان کردن لیست با کلیک بیرون از آن
//         document.addEventListener('click', (e) => {
//             if (!customSelectWrapper.contains(e.target)) {
//                 optionsContainer.style.display = 'none';
//                 customSelectWrapper.classList.remove('open');
//             }
//         });
//
//         // تابع فیلتر کردن گزینه‌ها
//         function filterOptions(searchTerm) {
//             const optionItems = optionsContainer.querySelectorAll('.option-item');
//             optionItems.forEach(item => {
//                 const text = item.textContent.toLowerCase();
//                 if (text.includes(searchTerm)) {
//                     item.style.display = 'block';
//                 } else {
//                     item.style.display = 'none';
//                 }
//             });
//         }
//
//         // قابلیت جستجو در زمان تایپ
//         searchInput.addEventListener('input', (e) => {
//             const searchTerm = e.target.value.toLowerCase();
//             filterOptions(searchTerm);
//         });
//     });
// });
//
// document.addEventListener('livewire:load', () => {
//     Livewire.hook('message.processed', () => {
//         initCustomSelects(); // همون فانکشنی که تمام select‌هات رو می‌سازه
//     });
// });

//     document.addEventListener("DOMContentLoaded", () => {
//     document.querySelectorAll("a").forEach(link => {
//         if (!link.hasAttribute("target")) {
//             link.setAttribute("target", "_blank");
//         }
//     });
// });







function initCustomSelects() {
    // پیدا کردن تمام کامپوننت‌ها با کلاس .custom-select-wrapper
    const allCustomSelects = document.querySelectorAll('.custom-select-wrapper');

    allCustomSelects.forEach(customSelectWrapper => {
        const select = customSelectWrapper.querySelector('select');
        const optionsContainer = customSelectWrapper.querySelector('.options-container');
        const tagsContainer = customSelectWrapper.querySelector('.selected-tags-container');
        const searchInput = customSelectWrapper.querySelector('.search-input');
        const toggleButton = customSelectWrapper.querySelector('.toggle-button');
        const wireModelName = customSelectWrapper.dataset.model;
        const multiple = select.hasAttribute('multiple'); // 👈 تغییر شماره 1

        optionsContainer.innerHTML = '';
        tagsContainer.querySelectorAll('.selected-tag').forEach(tag => tag.remove());

        // ساخت گزینه‌ها در ظاهر سفارشی
        Array.from(select.options).forEach(option => {
            if (option.value === "") return;
            const optionItem = document.createElement('div');
            optionItem.className = 'option-item';
            optionItem.textContent = option.textContent;
            optionItem.dataset.value = option.value;

            if (option.selected && option.value !== "") {
                optionItem.classList.add('selected');

                const tag = document.createElement('span');
                tag.className = 'selected-tag';
                tag.dataset.value = option.value;

                const textSpan = document.createElement('span');
                textSpan.textContent = option.textContent;
                tag.appendChild(textSpan);

                const removeIcon = document.createElement('i');
                removeIcon.className = 'remove-tag fa-regular fa-xmark';
                tag.appendChild(removeIcon);

                tagsContainer.appendChild(tag);
            }

            optionsContainer.appendChild(optionItem);
        });

        // باز کردن لیست گزینه‌ها
        customSelectWrapper.addEventListener('click', (e) => {
            if (!e.target.closest('.remove-tag')) {
                optionsContainer.style.display = 'flex';
                searchInput.focus();
                customSelectWrapper.classList.add('open');
            }
        });

        // مدیریت انتخاب گزینه‌ها
        optionsContainer.addEventListener('click', (e) => {
            const target = e.target.closest('.option-item');
            if (target) {
                const value = target.dataset.value;
                const option = select.querySelector(`option[value="${value}"]`);

                if (multiple) {
                    // 👈 حالت چندانتخابی (همون کد قبلی)
                    if (!option.selected) {
                        option.selected = true;
                        target.classList.add('selected');

                        const tag = document.createElement('span');
                        tag.className = 'selected-tag';
                        tag.dataset.value = value;

                        const textSpan = document.createElement('span');
                        textSpan.textContent = option.textContent;
                        tag.appendChild(textSpan);

                        const removeIcon = document.createElement('i');
                        removeIcon.className = 'remove-tag fa-regular fa-xmark';
                        tag.appendChild(removeIcon);

                        tagsContainer.appendChild(tag);
                    } else {
                        option.selected = false;
                        target.classList.remove('selected');
                        customSelectWrapper.querySelector(`.selected-tag[data-value="${value}"]`).remove();
                    }
                } else {
                    // 👈 حالت تک‌انتخابی
// پاک کردن تمام کلاس selected از option-item ها
                    Array.from(optionsContainer.querySelectorAll('.option-item')).forEach(item => item.classList.remove('selected'));

// پاک کردن تگ قبلی از tagsContainer
                    const prevTag = tagsContainer.querySelector('.selected-tag');
                    if(prevTag) prevTag.remove();

// انتخاب جدید رو ست کن
                    option.selected = true;
                    target.classList.add('selected');

                    const tag = document.createElement('span');
                    tag.className = 'selected-tag';
                    tag.dataset.value = value;

                    const textSpan = document.createElement('span');
                    textSpan.textContent = option.textContent;
                    tag.appendChild(textSpan);

                    const removeIcon = document.createElement('i');
                    removeIcon.className = 'remove-tag fa-regular fa-xmark';
                    tag.appendChild(removeIcon);

                    tagsContainer.appendChild(tag);

// بعد از انتخاب، لیست بسته بشه
                    optionsContainer.style.display = 'none';
                    customSelectWrapper.classList.remove('open');
                }

                updateLivewireValue(customSelectWrapper, wireModelName);
                searchInput.value = '';
                filterOptions('');
                searchInput.focus();
            }
        });

        // مدیریت حذف تگ‌ها
        tagsContainer.addEventListener('click', (e) => {
            const removeButton = e.target.closest('.remove-tag');
            if (removeButton) {
                const tag = removeButton.closest('.selected-tag');
                const value = tag.dataset.value;

                // غیر فعال کردن گزینه در select
                const option = select.querySelector(`option[value="${value}"]`);
                if(option) option.selected = false;

                // حذف فقط تگ کلیک شده
                tag.remove();

                // پاک کردن کلاس selected از option-item مربوطه
                const optionItem = optionsContainer.querySelector(`.option-item[data-value="${value}"]`);
                if(optionItem) optionItem.classList.remove('selected');

                // باز کردن لیست گزینه‌ها و focus روی input
                optionsContainer.style.display = 'flex';
                customSelectWrapper.classList.add('open');
                searchInput.value = '';
                searchInput.focus();

                // بروزرسانی Livewire
                updateLivewireValue(customSelectWrapper, wireModelName);
            }
        });



        function updateLivewireValue(wrapper, modelName) {
            const select = wrapper.querySelector('select');
            const multiple = select.hasAttribute('multiple');
            let selectedValues;

            if (multiple) {
                selectedValues = Array.from(wrapper.querySelectorAll('option:checked')).map(o => o.value);
            } else {
                const opt = wrapper.querySelector('option:checked');
                selectedValues = opt ? opt.value : null;
            }

            const compEl = wrapper.closest('[wire\\:id]');
            if (!compEl) return;

            const comp = Livewire.find(compEl.getAttribute('wire:id'));

            comp.set('value', selectedValues);
        }

        // پنهان کردن لیست با کلیک بیرون از آن
        document.addEventListener('click', (e) => {
            if (!customSelectWrapper.contains(e.target)) {
                optionsContainer.style.display = 'none';
                customSelectWrapper.classList.remove('open');
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
}

document.addEventListener('livewire:load', () => {
    Livewire.hook('message.processed', () => {
        initCustomSelects(); // همون فانکشنی که تمام select‌هات رو می‌سازه
    });
});

document.addEventListener('livewire:init', () => {
    Livewire.on('init-custom-select', () => {
        initCustomSelects();
    });
});

// document.addEventListener('livewire:load', () => {
//     Livewire.on('season-saved', event => {
//         window.location.href = event.url;
//     });
// });



