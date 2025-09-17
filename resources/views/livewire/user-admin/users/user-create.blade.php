<div class="space-y-6" x-data="{
    showPassword: false,
    removePassword: @entangle('remove_password'),
    toggleRemovePassword() {
        this.removePassword = !this.removePassword;
        if (this.removePassword) {
            $wire.set('password', null);
            $wire.set('password_confirmation', null);
        }
    }
}">

    <form class="grid grid-cols-1 gap-6 md:grid-cols-2" wire:submit.prevent="save">


        <!-- نام -->
        <x-forms.input-field
            name="name"
            label="نام"
            placeholder="علی کریمی"
            required
            wire:model="name"
        />

        <!-- ایمیل -->
        <x-forms.input-field
            name="email"
            label="ایمیل"
            type="email"
            wire:model="email"
            placeholder="info@example.com"
            required
        />

        <!-- وضعیت -->
        {{--        <livewire:components.forms.select-box-field--}}
        {{--            wire:model="status"--}}
        {{--            label="وضعیت"--}}
        {{--            enum-class="App\Enums\UserStatus"--}}
        {{--            :required="true"--}}
        {{--        />--}}
        <x-forms.select-field
            required
            name="status"
            label="وضعیت"
            :options="\App\Enums\UserStatus::cases()"
            wire:model.defer="status"
        />

        <!-- ادمین؟ -->
        {{--        <div class="flex items-center">--}}
        {{--            <input type="checkbox" id="is_admin" wire:model="is_admin"--}}
        {{--                   class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700">--}}
        {{--            <label for="is_admin" class="mr-2 block text-sm font-medium text-gray-700 dark:text-gray-300">--}}
        {{--                ادمین؟--}}
        {{--            </label>--}}
        {{--        </div>--}}

        <x-forms.switch-field
            name="is_admin"
            label="ادمین ؟"
            wire:model.defer="is_admin"
        />
        {{--        <livewire:components.forms.check-box-field--}}
        {{--            name="is_admin"--}}
        {{--            label="ادمین؟"--}}
        {{--            :checked="$is_admin"--}}
        {{--            value="true"--}}
        {{--            unchecked-value="false"--}}
        {{--        />--}}

        <!-- رمز عبور -->
        {{--        <div x-show="!removePassword">--}}
        {{--            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">--}}
        {{--                رمز عبور <span class="text-red-500">*</span>--}}
        {{--            </label>--}}
        {{--            <div class="relative">--}}
        {{--                <input :type="showPassword ? 'text' : 'password'" id="password" wire:model="password"--}}
        {{--                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500">--}}
        {{--                <button type="button" @click="showPassword = !showPassword"--}}
        {{--                        class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">--}}
        {{--                    <span x-show="!showPassword">--}}
        {{--                        <!-- آیکون چشم (مخفی) -->--}}
        {{--                        <svg class="w-5 h-5 fill-transparent">--}}
        {{--                        <use xlink:href="#icon-eye"></use>--}}
        {{--                    </svg>--}}
        {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"--}}
        {{--                             stroke="currentColor">--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
        {{--                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
        {{--                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>--}}
        {{--                        </svg>--}}
        {{--                    </span>--}}
        {{--                    <span x-show="showPassword">--}}
        {{--                        <!-- آیکون چشم (نمایش) -->--}}
        {{--                        <svg class="w-5 h-5 fill-transparent">--}}
        {{--                        <use xlink:href="#icon-eye-closed"></use>--}}
        {{--                    </svg>--}}
        {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"--}}
        {{--                             stroke="currentColor">--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
        {{--                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>--}}
        {{--                        </svg>--}}
        {{--                    </span>--}}
        {{--                </button>--}}
        {{--            </div>--}}
        {{--            @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror--}}
        {{--        </div>--}}
        <x-forms.password-field
            name="password"
            label="رمز عبور"
            wire:model.defer="remove_password"
            required
        />


        <!-- رمز عبور حذف شود؟ -->
        {{--        <div class="flex items-center">--}}
        {{--            <input type="checkbox" id="remove_password" x-model="removePassword" @change="toggleRemovePassword()"--}}
        {{--                   class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700">--}}
        {{--            <label for="remove_password" class="mr-2 block text-sm font-medium text-gray-700 dark:text-gray-300">--}}
        {{--                رمز عبور حذف شود؟--}}
        {{--            </label>--}}
        {{--        </div>--}}
        <x-forms.switch-field
            name="remove_password"
            label="رمز عبور حذف شود؟"
            wire:model.defer="remove_password"
        />

        <!-- تصویر -->
{{--        <div class="md:col-span-2">--}}
{{--            <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">--}}
{{--                تصویر--}}
{{--            </label>--}}
{{--            <div x-data="{ isUploading: false, progress: 0 }"--}}
{{--                 x-on:livewire-upload-start="isUploading = true"--}}
{{--                 x-on:livewire-upload-finish="isUploading = false"--}}
{{--                 x-on:livewire-upload-error="isUploading = false"--}}
{{--                 x-on:livewire-upload-progress="progress = $event.detail.progress">--}}
{{--                <input type="file" id="avatar" wire:model="avatar"--}}
{{--                       class="block w-full text-sm text-gray-500 dark:text-gray-400--}}
{{--                              file:mr-4 file:py-2 file:px-4--}}
{{--                              file:rounded-lg file:border-0--}}
{{--                              file:text-sm file:font-semibold--}}
{{--                              file:bg-primary-50 file:text-primary-700 dark:file:bg-primary-800 dark:file:text-primary-200--}}
{{--                              hover:file:bg-primary-100 dark:hover:file:bg-primary-700">--}}

{{--                <div x-show="isUploading" class="mt-2">--}}
{{--                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">--}}
{{--                        <div class="bg-primary-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>--}}
{{--                    </div>--}}
{{--                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="`در حال آپلود: ${progress}%`"></span>--}}
{{--                </div>--}}

{{--                @error('avatar') <span class="text-sm text-red-500">{{ $message }}</span> @enderror--}}

{{--                @if($avatar)--}}
{{--                    <div class="mt-2">--}}
{{--                        <img src="{{ is_string($avatar) ? asset('storage/' . $avatar) : $avatar->temporaryUrl() }}"--}}
{{--                             alt="پیش‌نمایش تصویر" class="h-24 object-contain border rounded-lg">--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <livewire:components.forms.file-upload--}}
{{--            name="avatar"--}}
{{--            label="تصویر پروفایل"--}}
{{--            wire:model="avatar"--}}
{{--            required--}}
{{--        />--}}
        <div x-data="{ isUploading: false, progress: 0, filename: '' }"
             x-on:livewire-upload-start="isUploading = true; progress = 0"
             x-on:livewire-upload-finish="isUploading = false; progress = 100"
             x-on:livewire-upload-error="isUploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress"
             class="mb-4">


                <label for="avatar" class="block text-sm font-medium text-black dark:text-white mb-1">
                    تصویر پروفایل
                        <span class="text-red-500">*</span>
                </label>

            <div class="flex flex-col border-[1.4px] border-border-c dark:bg-gray-800 rounded-md py-2 px-2.5 gap-3 cursor-pointer" @click="$refs.fileInput.click()">
                <input
                    type="file"
                    id="avatar"
                    wire:model="avatar"
                    x-ref="fileInput"
                    @change="filename = $refs.fileInput.files.length ? $refs.fileInput.files[0].name : ''"
                    class="hidden"
                >
                <div class="flex relative">
                    <div class="flex items-center gap-x-3.5">

                        <div>
                            @if($avatar)
                                <img src="{{ is_string($avatar) ? asset('storage/' . $avatar) : $avatar->temporaryUrl() }}"
                                     alt="Preview" class="h-10 w-10 rounded-full">
                            @else
                                <div class="flex justify-center items-center h-10 w-10 rounded-full border-[1.4px]">
                                    <svg class="w-6 h-6 fill-transparent">
                                        <use xlink:href="#icon-image"></use>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="">
                        <span x-show="!filename" class="cursor-pointer select-none"
                              @click="$refs.fileInput.click()">انتخاب فایل</span>
                                <span x-text="filename" class="cursor-pointer select-none" @click="$refs.fileInput.click()"></span>
                            </div>
                            <button  type="button" class="text-red-500 hover:text-red-700 absolute top-0 -left-1 bg-red-300/25 flex py-1 px-0.5 rounded-sm cursor-pointer select-none"
                                     @click="$refs.fileInput.value = ''; filename=''; $wire.set('avatar', null)">
                                <i class="fa-light fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div>
                    <div class="flex justify-center items-center gap-x-1.5" x-cloak>
                        <div class="w-[94%] bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-c dark:bg-yellow-c h-2.5 rounded-full transition-all duration-300"
                                 :style="`width: ${progress}%`"></div>
                        </div>
                        <span class="text-xs text-blue-c dark:text-yellow-c select-none" x-text="`${progress}%`"></span>
                    </div>
                </div>
            </div>

            @error('avatar')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex justify-end items-center">
            <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ذخیره</a>
{{--            <button type="button" wire:click="save"--}}
{{--                    class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">--}}
{{--                ایجاد کاربر--}}
{{--            </button>--}}
        </div>
    </form>
</div>
