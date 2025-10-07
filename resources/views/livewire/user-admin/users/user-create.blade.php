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
        <x-forms.select-field
            required
            name="status"
            label="وضعیت"
            :options="\App\Enums\UserStatus::cases()"
            wire:model.defer="status"
        />


        <x-forms.switch-field
            name="is_admin"
            label="ادمین ؟"
            wire:model.defer="is_admin"
        />

        <x-forms.password-field
            name="password"
            label="رمز عبور"
            wire:model.defer="remove_password"
            required
        />


        <x-forms.switch-field
            name="remove_password"
            label="رمز عبور حذف شود؟"
            wire:model.defer="remove_password"
        />

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
{{--            <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ذخیره</a>--}}
            <button type="submit"
                    class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">
                ذخیره
            </button>
        </div>
    </form>
</div>
