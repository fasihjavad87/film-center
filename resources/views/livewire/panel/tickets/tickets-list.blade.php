{{--<div class="space-y-3">--}}
{{--    <div class="flex justify-between items-center mb-4">--}}
{{--        <h2 class="text-lg font-bold">تیکت‌ها</h2>--}}
{{--        <a href="{{ route('panel.tickets.create') }}"--}}
{{--           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">--}}
{{--            + ایجاد تیکت جدید--}}
{{--        </a>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="space-y-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">تیکت های من</h2>
            <a href="{{ route('panel.tickets.create') }}"
               class="text-blue-c dark:text-yellow-c hover:bg-blue-c/10 dark:hover:bg-yellow-c/10  border-blue-c/30  dark:border-yellow-c/30 transition-colors flex justify-center items-center gap-x-2 border-[1.3px] rounded-[10px] p-2.5 text-sm">
               <span>تیکت جدید</span>
                <i class="fa-light fa-plus"></i>
            </a>
        </div>
    <div class="overflow-x-auto hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden" wire:key="user-list-table">
            <table class="box-table w-full text-sm">
                <thead class="table-head">
                <tr>
                    <th>عنوان</th>
                    {{--                    <th>کاربر</th>--}}
                    <th>آخرین پیام</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>مشاهده</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tickets as $ticket)
                    <tr class="table-item border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="p-2 font-bold">{{ $ticket->subject }}</td>
                        {{--                        <td class="p-2">{{ $ticket->user->name }}</td>--}}
                        <td class="p-2">{{ $ticket->lastMessage ? Str::limit($ticket->lastMessage->message, 50) : '-' }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-xs {{ $ticket->statusClasses() }}">
                                {{ $ticket->statusLabel() }}
                            </span>
                        </td>
                        <td>
                            <span
                                class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($ticket->created_at)->format('Y/m/d') }}</span>
                        </td>
                        <!-- منوی عملیات -->
                        <td class="p-2 flex justify-center">
                            <a href="{{ route('panel.tickets.show', $ticket->id ) }}" wire:navigate
                               class="text-green-400 hover:text-green-500">
                                <svg class="w-22px h-22px fill-transparent">
                                    <use xlink:href="#icon-eye"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center">هیچ تیکتی پیدا نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="w-full flex md:hidden flex-col gap-4">
        <div class="bg-blue-400/10 dark:bg-gray-800 grid grid-cols-2 gap-4 p-3 rounded-xl">
            <div class="col-span-full flex flex-col gap-1"><span class="text-sm opacity-60">عنوان</span><a
                    href="{{ route('panel.tickets.show', $ticket->id) }}" wire:navigate class="text-blue-500 dark:text-white font-semibold text-lg cursor-pointer">{{ $ticket->subject }}</a></div>
            <div class="flex flex-col gap-1"><span
                    class="text-sm opacity-60">تاریخ ثبت</span><span></span>{{ \Hekmatinasser\Verta\Verta::instance($ticket->created_at)->format('Y/m/d') }}</div>
            <div class="flex flex-col gap-1"><span class="text-sm opacity-60">وضعیت</span><span
                    class="px-2 py-1 rounded text-xs w-max {{ $ticket->statusClasses() }}">{{ $ticket->statusLabel() }}</span></div>
            <div class="col-span-full">
                <div class="flex items-center gap-2.5"><a href="{{ route('panel.tickets.show', $ticket->id) }}" wire:navigate
                                                          class="bg-blue-c hover:bg-blue-c/30 text-white dark:text-black dark:bg-yellow-c dark:hover:bg-yellow-c/30 rounded-lg flex justify-center items-center py-2 w-full">نمایش
                        <!----><span
                            class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 w-max"></span></a></div>
            </div>
        </div>
    </div>
    <!-- صفحه‌بندی -->
    <div class="flex justify-center mt-6">
        {{ $tickets->links('vendor.pagination.custom-pagination-panel-tailwind') }}
    </div>
</div>

