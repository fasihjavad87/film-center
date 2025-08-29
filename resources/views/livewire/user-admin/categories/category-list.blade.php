<div class="">
    <div class="card">
        <div class="card-body">

            <div class="flex flex-col-reverse md:flex-row md:justify-between items-start">
                <div class="search w-full md:w-[60%] mt-4 md:mt-0">
                    <label class="label-search">عنوان جستجو</label>
                    <div class="sm:w-4/5">
                        <input type="text" dir="rtl"
                               class="input-search" wire:model.live.debounce.300ms="search">
                    </div>
                </div>
                <div class="flex gap-x-1 w-full md:w-max justify-between">
                    <a href="{{ route('panelAdmin.categories.create') }}" class="bg-green-500 text-white w-max px-3.5 py-2 rounded-lg">افزودن</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden" wire:key="user-list-table">
                    <table class="box-table">
                        <thead class="table-head">
                        <tr>
                            <th>عنوان</th>
                            <th>عنوان انگلیسی</th>
                            <th>نشانی</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr class="table-item">
                                <td><span class="font-medium">{{ $category->name }}</span></td>
                                <td><span class="font-medium">{{ $category->e_name }}</span></td>
                                <td><span class="font-medium">{{ $category->slug }}</span></td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    <a href="{{ route('panelAdmin.categories.edite', $category->id ) }}"
                                       class="text-blue-400 hover:text-blue-500">
                                        <svg class="w-22px h-22px fill-transparent">
                                            <use xlink:href="#icon-pen-new-square"></use>
                                        </svg>
                                    </a>
                                    <div x-data="{ showDeleteModal: @entangle('showDeleteModal') }">

                                        <a href=""
                                           class="text-red-400 hover:text-red-500"
                                           wire:click.prevent="openDeleteModal({{ $category->id }})">
                                            <svg class="w-6 h-6 fill-transparent">
                                                <use xlink:href="#icon-trash-bin-minimalistic"></use>
                                            </svg>
                                        </a>

                                        <div
                                            x-show="showDeleteModal" x-cloak
                                            x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="ease-in duration-300"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center z-50">
                                            <div
                                                class="bg-white p-6 w-[440px] h-[180px] flex flex-col justify-center items-center rounded-xl shadow-lg">
                                                <p>آیا مطمئن هستید که می‌خواهید این دسته بندی را حذف کنید؟</p>
                                                <div class="mt-4 flex justify-end gap-2">
                                                    <button
                                                        wire:click="closeDeleteModal"
                                                        class="bg-gray-300 px-4 py-2 rounded cursor-pointer"
                                                    >لغو
                                                    </button>
                                                    <button
                                                        wire:click="delete"
                                                        class="bg-red-500 text-white px-4 py-2 rounded cursor-pointer"
                                                    >حذف
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="flex justify-center mt-10">
                <div class="flex space-x-2 rtl:space-x-reverse">
                    {{ $categories->links('vendor.pagination.custom-pagination-panel-tailwind') }}
                </div>
            </div>

        </div>
    </div>
</div>
