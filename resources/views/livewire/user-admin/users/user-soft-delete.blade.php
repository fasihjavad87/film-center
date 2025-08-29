{{--<div>--}}
{{--    <h2 class="text-2xl font-bold mb-4">کاربران حذف شده</h2>--}}

{{--    <div class="overflow-x-auto">--}}
{{--        <div class="parent-table min-w-full">--}}
{{--            <table class="box-table">--}}
{{--                <thead class="table-head">--}}
{{--                <tr>--}}
{{--                    <th>عکس</th>--}}
{{--                    <th>نام و نام خانوادگی</th>--}}
{{--                    <th>ایمیل</th>--}}
{{--                    <th>تاریخ حذف</th>--}}
{{--                    <th></th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($trashedUsers as $user)--}}
{{--                    <tr class="table-item">--}}
{{--                        <td><img src="{{ asset('uploads/' . $user->avatar) }}" alt="image" class="table-avatar"></td>--}}
{{--                        <td>{{ $user->name }}</td>--}}
{{--                        <td>{{ $user->email }}</td>--}}
{{--                        <td>{{ \Hekmatinasser\Verta\Verta::instance($user->deleted_at)->format('Y/m/d') }}</td>--}}
{{--                        <td>--}}
{{--                            <a href="#" class="text-red-400 hover:text-red-500" wire:click.prevent="openDeleteModal({{ $user->id }})">--}}
{{--                                <svg class="w-6 h-6 fill-transparent"><use xlink:href="#icon-trash-bin-minimalistic"></use></svg>--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="flex justify-center mt-10">--}}
{{--        {{ $trashedUsers->links() }}--}}
{{--    </div>--}}

{{--    <div x-data="{ showDeleteModal: @entangle('showDeleteModal') }">--}}
{{--        <div x-show="showDeleteModal" x-cloak--}}
{{--             x-transition:enter="ease-out duration-300"--}}
{{--             x-transition:enter-start="opacity-0 scale-95"--}}
{{--             x-transition:enter-end="opacity-100 scale-100"--}}
{{--             x-transition:leave="ease-in duration-300"--}}
{{--             x-transition:leave-start="opacity-100 scale-100"--}}
{{--             x-transition:leave-end="opacity-0 scale-95"--}}
{{--             class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center z-50">--}}
{{--            <div class="bg-white p-6 w-[440px] h-[180px] flex flex-col justify-center items-center rounded-xl shadow-lg">--}}
{{--                <p>آیا مطمئن هستید که می‌خواهید این کاربر را به صورت دائمی حذف کنید؟</p>--}}
{{--                <div class="mt-4 flex justify-end gap-2">--}}
{{--                    <button wire:click="closeDeleteModal" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">لغو</button>--}}
{{--                    <button wire:click="forceDelete" class="bg-red-500 text-white px-4 py-2 rounded cursor-pointer">حذف دائمی</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</div>--}}

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
                                <td><span class="font-medium">{{ $user->name }}</span></td>
                                <td><span class="font-medium">{{ $user->email }}</span></td>
                                <td>
                                    <span
                                        class="font-medium">{{ \Hekmatinasser\Verta\Verta::instance($user->deleted_at)->format('Y/m/d') }}</span>
                                </td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    <div x-data="{ showRestoreModal: @entangle('showRestoreModal') }">

                                        <a href="#"
                                           wire:click.prevent="openRestoreModal({{ $user->id }})"
                                           class="text-blue-400 hover:text-blue-500">
                                            <svg class="w-6 h-6 fill-transparent">
                                                <use xlink:href="#icon-restart"></use>
                                            </svg>
                                        </a>

                                        <div
                                            x-show="showRestoreModal" x-cloak
                                            x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="ease-in duration-300"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center z-50">
                                            <div
                                                class="bg-white p-6 w-[440px] h-[180px] flex flex-col justify-center items-center rounded-xl shadow-lg">
                                                <p>آیا مطمئن هستید که می خواهید این کاربر را بازگردانید؟</p>
                                                <div class="mt-4 flex justify-end gap-2">
                                                    <button
                                                        wire:click="closeRestoreModal"
                                                        class="bg-gray-300 px-4 py-2 rounded cursor-pointer"
                                                    >لغو
                                                    </button>
                                                    <button
                                                        wire:click="restore"
                                                        class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer"
                                                    >بازگردانی
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div x-data="{ showDeleteModal: @entangle('showDeleteModal') }">

                                        <a href=""
                                           class="text-red-400 hover:text-red-500"
                                           wire:click.prevent="openDeleteModal({{ $user->id }})">
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
                                                <p>آیا مطمئن هستید که می‌خواهید این کاربر را به صورت دائمی حذف کنید؟</p>
                                                <div class="mt-4 flex justify-end gap-2">
                                                    <button
                                                        wire:click="closeDeleteModal"
                                                        class="bg-gray-300 px-4 py-2 rounded cursor-pointer"
                                                    >لغو
                                                    </button>
                                                    <button
                                                        wire:click="forceDelete"
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
                    {{ $trashedUsers->links('vendor.pagination.custom-pagination-panel-tailwind') }}
                </div>
            </div>

        </div>
    </div>
</div>

