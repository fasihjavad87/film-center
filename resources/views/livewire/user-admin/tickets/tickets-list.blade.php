<div class="space-y-6">
    <!-- فیلترها -->
    <div x-data="{ active: @entangle('statusFilter') }" class="grid grid-cols-5 gap-4">
        @php
            $statusClasses = [
                'all' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200',
                'open' => 'bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-100',
                'answered' => 'bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-100',
                'pending' => 'bg-yellow-100 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-100',
                'closed' => 'bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-100',
            ];
        @endphp

        @foreach(['all' => 'همه', 'open' => 'باز', 'answered' => 'پاسخ داده‌شده', 'pending' => 'در انتظار پاسخ', 'closed' => 'بسته شده'] as $key => $label)
            <div @click="active = '{{ $key }}'; $wire.setFilter('{{ $key }}')"
                 class="cursor-pointer p-4 border rounded-xl text-center transition-all duration-300 ease-in-out transform"
                 :class="active === '{{ $key }}'
                        ? 'bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg scale-105'
                        : '{{ $statusClasses[$key] }}'">
                <div class="text-lg font-bold">{{ $counts[$key] ?? 0 }}</div>
                <div class="text-sm">{{ $label }}</div>
            </div>
        @endforeach
    </div>

    <!-- جدول تیکت‌ها -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden" wire:key="user-list-table">
            <table class="box-table w-full text-sm">
                <thead class="table-head">
                <tr>
                    <th>عنوان</th>
                    <th>کاربر</th>
                    <th>آخرین پیام</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($tickets as $ticket)
                    <tr class="table-item border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="p-2 font-bold">{{ $ticket->subject }}</td>
                        <td class="p-2">{{ $ticket->user->name }}</td>
                        <td class="p-2">{{ $ticket->lastMessage ? Str::limit($ticket->lastMessage->message, 50) : '-' }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-xs {{ $ticket->statusClasses() }}">
                                {{ $ticket->statusLabel() }}
                            </span>
                        </td>
                        <td>
                            <span class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($ticket->created_at)->format('Y/m/d') }}</span>
                        </td>
                        <!-- منوی عملیات -->
                        <td class="p-2 relative">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('panelAdmin.tickets.show', $ticket->id ) }}" wire:navigate
                                   class="text-green-400 hover:text-green-500">
                                    <svg class="w-22px h-22px fill-transparent">
                                        <use xlink:href="#icon-square-arrow-left-up"></use>
                                    </svg>
                                </a>
                                <a href="#" wire:click.prevent="openDeleteTicketModal({{ $ticket->id }})"
                                   class="text-red-400 hover:text-red-500">
                                    <svg class="w-6 h-6 fill-transparent">
                                        <use xlink:href="#icon-trash-bin-minimalistic"></use>
                                    </svg>
                                </a>
                            </div>
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

    <!-- صفحه‌بندی -->
    <div class="flex justify-center mt-10">
        <div class="flex space-x-2 rtl:space-x-reverse">
            {{ $tickets->links('vendor.pagination.custom-pagination-panel-tailwind') }}
        </div>
    </div>

    <!-- مودال حذف -->
    <div x-data="{ showDeleteTicketModal: false }"
         x-on:show-delete-ticket-modal.window="showDeleteTicketModal = true"
         x-on:close-delete-ticket-modal.window="showDeleteTicketModal = false" x-cloak>

        <div x-show="showDeleteTicketModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-[270px] md:w-[440px] flex flex-col items-center relative">
                <p class="text-black dark:text-white">آیا مطمئن هستید که می‌خواهید این تیکت را حذف کنید؟</p>
                <div class="mt-4 flex justify-end gap-2 absolute bottom-2.5 left-5">
                    <button x-on:click="showDeleteTicketModal = false"
                            class="button-delete-custom">لغو
                    </button>
                    <button wire:click="deleteTicket"
                            class="button-delete-close-custom">حذف
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
