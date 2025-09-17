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
                    <a href="{{ route('panelAdmin.movies.create') }}" wire:navigate class="bg-green-500 text-white w-max px-3.5 py-2 rounded-lg">افزودن</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden" wire:key="user-list-table">
                    <table class="box-table">
                        <thead class="table-head">
                        <tr>
                            <th>پوستر</th>
                            <th>عنوان</th>
                            <th>نام انگلیسی</th>
                            <th>نشانی</th>
                            <th>وضعیت</th>
                            <th>تاریخ ایجاد</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($movies as $movie)
                            <tr class="table-item">
                                <td>
                                    <div class="flex justify-center">
                                        <img src="{{ asset('uploads/' . $movie->details->poster) }}" alt="image"
                                             class="table-avatar">
                                    </div>
                                </td>
                                <td><span class="font-normal">{{ $movie->title }}</span></td>
                                <td><span class="font-normal">{{ $movie->e_name }}</span></td>
                                <td><span class="font-normal">{{ $movie->slug }}</span></td>
                                <td>
                                <span class="{{ $movie->statusClasses() }}">
                                    {{ $movie->statusLabel() }}
                                </span>
                                </td>
                                <td>
                                    <span
                                        class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($movie->created_at)->format('Y/m/d') }}</span>
                                </td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    <a href="{{ route('panelAdmin.movies.edite', $movie->id ) }}" wire:navigate
                                       class="text-blue-400 hover:text-blue-500">
                                        <svg class="w-22px h-22px fill-transparent">
                                            <use xlink:href="#icon-pen-new-square"></use>
                                        </svg>
                                    </a>
                                    <a href="#" wire:click.prevent="openDeleteModal({{ $movie->id }})"
                                       class="text-red-400 hover:text-red-500">
                                        <svg class="w-6 h-6 fill-transparent">
                                            <use xlink:href="#icon-trash-bin-minimalistic"></use>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="flex justify-center mt-10">
                <div class="flex space-x-2 rtl:space-x-reverse">
                    {{ $movies->links('vendor.pagination.custom-pagination-panel-tailwind') }}
                </div>
            </div>

        </div>
    </div>
    <div x-data="{ showDeleteModal: false }"
         x-on:show-delete-modal.window="showDeleteModal = true"
         x-on:close-delete-modal.window="showDeleteModal = false" x-cloak>

        <div x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl md:right-[120px] w-[270px] md:w-[440px] h-[183px] md:h-[180px] flex flex-col justify-self-start md:justify-center items-center relative">
                <p class="text-black dark:text-white">آیا مطمئن هستید که می‌خواهید این فیلم را حذف کنید؟</p>
                <div class="mt-4 flex justify-end gap-2 absolute bottom-2.5 left-5">
                    <button x-on:click="showDeleteModal = false"
                            class="button-delete-custom">لغو
                    </button>
                    <button wire:click="delete"
                            class="button-delete-close-custom">حذف
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
