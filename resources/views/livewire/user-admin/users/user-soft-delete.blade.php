<div class="">
    <div class="card">
        <h2 class="text-xl font-normal py-3 px-3.5">کاربران حذف شده</h2>
        <div class="card-body">

            <div class="search">
                <label class="label-search">عنوان جستجو</label>
                <div class="sm:w-4/5">
                    <input type="text" dir="rtl"
                           class="input-search" wire:model.live.debounce.300ms="search">
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden" wire:key="user-list-table">
                    <table class="box-table">
                        <thead class="table-head">
                        <tr>
                            <th>عکس</th>
                            <th>نام و نام خانوادگی</th>
                            <th>ایمیل</th>
                            <th>تاریخ حذف</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trashedUsers as $user)
                            <tr class="table-item">
                                <td>
                                    <div class="flex justify-center">
                                        <img src="{{ asset('uploads/' . $user->avatar) }}" alt="image"
                                             class="table-avatar">
                                    </div>
                                </td>
                                <td><span class="font-normal">{{ $user->name }}</span></td>
                                <td><span class="font-normal">{{ $user->email }}</span></td>
                                <td>
                                    <span
                                        class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($user->deleted_at)->format('Y/m/d') }}</span>
                                </td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    <a href="#" wire:click.prevent="openRestoreModal({{ $user->id }})"
                                       class="text-blue-400 hover:text-blue-500">
                                        <svg class="w-6 h-6 fill-transparent">
                                            <use xlink:href="#icon-restart"></use>
                                        </svg>
                                    </a>
                                    <a href="#" wire:click.prevent="openDeleteModal({{ $user->id }})"
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
                    {{ $trashedUsers->links('vendor.pagination.custom-pagination-panel-tailwind') }}
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
                <p class="text-black dark:text-white">آیا مطمئن هستید که می‌خواهید این کاربر را به صورت دائمی حذف کنید؟</p>
                <div class="mt-4 flex justify-end gap-2 absolute bottom-2.5 left-5">
                    <button x-on:click="showDeleteModal = false"
                            class="button-delete-custom">لغو
                    </button>
                    <button wire:click="forceDelete"
                            class="button-delete-close-custom">حذف
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{ showRestoreModal: false }"
         x-on:show-restore-modal.window="showRestoreModal = true"
         x-on:close-restore-modal.window="showRestoreModal = false" x-cloak>

        <div x-show="showRestoreModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl md:right-[120px] w-[270px] md:w-[440px] h-[183px] md:h-[180px] flex flex-col justify-self-start md:justify-center items-center relative">
                <p class="text-black dark:text-white">آیا مطمئن هستید که می خواهید این کاربر را بازگردانید؟</p>
                <div class="mt-4 flex justify-end gap-2 absolute bottom-2.5 left-5">
                    <button x-on:click="showRestoreModal = false"
                            class="button-delete-custom">لغو
                    </button>
                    <button wire:click="restore"
                            class="button-delete-close-custom">بازگردانی
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

