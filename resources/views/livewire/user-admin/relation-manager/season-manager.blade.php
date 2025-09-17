<div>
    <div class="card mt-7">
        <div class="card-body">

            <div class="flex flex-col-reverse md:flex-row md:justify-between items-start">
                <div class="search w-full md:w-[60%] mt-4 md:mt-0">
                    <label class="label-search">فصل ها</label>
                </div>
                <div class="flex gap-x-1 w-full md:w-max justify-between">
                    <a href="#" wire:click.prevent="openAddSeasonModal"
                       class="bg-green-500 text-white w-max px-3.5 py-2 rounded-lg">افزودن</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden"
                     wire:key="user-list-table">
                    <table class="box-table">
                        <thead class="table-head">
                        <tr>
                            <th>عنوان</th>
                            <th>شماره فصل</th>
                            <th>وضعیت</th>
                            <th>تاریخ ایجاد</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($seasons as $season)
                            <tr class="table-item">
                                <td><span class="font-normal">{{ $season->title }}</span></td>
                                <td><span class="font-normal">{{ $season->season_number }}</span></td>
                                <td>
                                <span class="{{ $season->statusClasses() }}">
                                    {{ $season->statusLabel() }}
                                </span>
                                </td>
                                <td>
                                    <span
                                        class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($season->created_at)->format('Y/m/d') }}</span>
                                </td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    <a href="{{ route('panelAdmin.seasons.edite', $season->id ) }}" wire:navigate
                                       class="text-green-400 hover:text-green-500">
                                        <svg class="w-22px h-22px fill-transparent">
                                            <use xlink:href="#icon-square-arrow-left-up"></use>
                                        </svg>
                                    </a>
                                    <a wire:click.prevent="editSeason({{ $season->id }})"
                                       class="text-blue-400 hover:text-blue-500">
                                        <svg class="w-22px h-22px fill-transparent">
                                            <use xlink:href="#icon-pen-new-square"></use>
                                        </svg>
                                    </a>
                                    <a href="#" wire:click.prevent="openDeleteSeasonModal({{ $season->id }})"
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


            {{--            <div class="flex justify-center mt-10">--}}
            {{--                <div class="flex space-x-2 rtl:space-x-reverse">--}}
            {{--                    {{ $trailers->links('vendor.pagination.custom-pagination-panel-tailwind') }}--}}
            {{--                </div>--}}
            {{--            </div>--}}

        </div>
    </div>
    <div x-data="{ openSeasonModal: false }"
         x-on:open-season-modal.window="openSeasonModal = true"
         x-on:close-season-modal.window="openSeasonModal = false" x-cloak>

        <div x-show="openSeasonModal" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50">
            <div class="bg-white relative dark:bg-gray-800 p-6 rounded-xl w-[822px] h-[400px] relative right-[136px]">
                <h2 class="text-xl mb-4">
                    {{ $editingSeasonId ? 'ویرایش فصل' : 'افزودن فصل جدید' }}
                </h2>
                <div class="grid grid-cols-2 gap-5">
                    <x-forms.input-field name="trailer_title" label="عنوان فصل" required wire:model="season_title"/>
                    <x-forms.input-field type="number" name="season_number" label="شماره فصل" required wire:model="season_number"/>
                    <x-forms.textarea name="season_description" label="توضیحات" required wire:model="season_description"/>
                    <x-forms.select-field
                        required
                        name="season_status"
                        label="وضعیت"
                        :options="\App\Enums\SeriesStatus::cases()"
                        wire:model.defer="season_status"
                    />

                </div>

                <div class="flex justify-end gap-2 absolute left-5 bottom-4">
                    <button x-on:click="openSeasonModal = false" class="button-close-custom">
                        انصراف
                    </button>
                    <button wire:click="saveSeason" class="button-custom">
                        {{ $editingSeasonId ? 'ویرایش' : 'ایجاد' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{ showDeleteSeasonModal: false }"
         x-on:show-delete-season-modal.window="showDeleteSeasonModal = true"
         x-on:close-delete-season-modal.window="showDeleteSeasonModal = false" x-cloak>

        <div x-show="showDeleteSeasonModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl md:right-[120px] w-[270px] md:w-[440px] h-[183px] md:h-[180px] flex flex-col justify-self-start md:justify-center items-center relative">
                <p class="text-black dark:text-white">آیا مطمئن هستید که می‌خواهید این فصل را حذف کنید؟</p>
                <div class="mt-4 flex justify-end gap-2 absolute bottom-2.5 left-5">
                    <button x-on:click="showDeleteSeasonModal = false"
                            class="button-delete-custom">لغو
                    </button>
                    <button wire:click="deleteSeason"
                            class="button-delete-close-custom">حذف
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
