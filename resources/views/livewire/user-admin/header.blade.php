<section
    class="fixed top-0 left-0 w-full h-app-header-h bg-white z-20 md:z-50 dark:bg-gray-700 dark:text-white border-b border-b-border-c  flex justify-between items-center p-3.5">
    <button class="text-blue-c border-[1.3px] border-border-b-c/30
           dark:border-yellow-400/30 dark:text-yellow-400
           w-btn h-btn text-xl flex justify-center items-center
           rounded-lg md:hidden" @click="sidebarOpen = true"><i
            class="fa-regular fa-bars"></i></button>
    <span>Header</span>
    <div
        class="flex gap-x-1.5"
        x-data="{
        dark: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            const icon = this.$refs.icon;
            icon.classList.add('rotate-180');
            setTimeout(() => {
                this.dark = !this.dark;
                if (this.dark) {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                }
                icon.classList.remove('rotate-180');
            }, 300);
        }
    }"
    >
        <button
            @click="toggleTheme"
            class="border-[1.3px] cursor-pointer border-border-b-c/30 dark:border-yellow-400/30 w-btn h-btn text-xl flex justify-center items-center rounded-lg"
        >
            <svg
                x-ref="icon"
                class="transition-transform duration-300 w-6 h-6 fill-transparent"
                :class="dark ? 'text-yellow-400' : 'text-blue-c'">
                <use href="#icon-sun" x-show="dark"></use>
                <use href="#icon-moon" x-show="!dark"></use>
            </svg>
        </button>
        <div class="relative" x-data="{ menuUser: false }" @click.away="menuUser = false">

            <!-- دکمه -->
            <button
                @click="menuUser = !menuUser"
                class="text-blue-c border-[1.3px] border-border-b-c/30
           dark:border-yellow-400/30 dark:text-yellow-400
           w-btn h-btn text-xl flex justify-center items-center
           rounded-lg cursor-pointer transition-all">
                <svg class="w-7 h-7 fill-transparent">
                    <use xlink:href="#icon-user"></use>
                </svg>
            </button>

            <!-- منو -->
            <div
                x-show="menuUser" x-cloak
                x-transition:enter="transition transform duration-200"
                x-transition:enter-start="scale-75 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transition transform duration-150"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-75 opacity-0"
                class="absolute z-30 top-[110%] left-0
           w-max min-w-[300px] p-5 rounded-2xl
           bg-white border border-border-c dark:bg-gray-700 shadow-2xl"
            >
                <div>
                    <div class="py-1.5 px-1.5 rounded-lg flex flex-col gap-1">
                        <h4 class="text-base font-semibold">{{ $name }}</h4>
                        <span class="text-10">{{ $email }}</span>
                    </div>
                    <hr class="w-full text-border-c">
                    <ul class="w-full flex flex-col gap-2.5 *:p-2.5">
                        <li class="*:block *:w-full *:h-full *:cursor-pointer "><a href="#"><i
                                    class="fa-light fa-bookmark"></i><span>لیست فیلم ها</span></a></li>
                        <li class="*:block *:w-full *:h-full *:cursor-pointer "><a href="#"><i
                                    class="fa-light fa-bookmark"></i><span>لیست فیلم ها</span></a></li>
                        <li class="*:block *:w-full *:h-full *:cursor-pointer "><a href="#"><i
                                    class="fa-light fa-bookmark"></i><span>لیست فیلم ها</span></a></li>
                        <li class="*:block *:w-full *:h-full *:cursor-pointer "><a href="#"><i
                                    class="fa-light fa-bookmark"></i><span>لیست فیلم ها</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="relative" x-data="{ menuNotification: false }" @click.away="menuNotification = false">

            <!-- دکمه -->
            <button
                @click="menuNotification = !menuNotification"
                class="text-blue-c border-[1.3px] border-border-b-c/30
           dark:border-yellow-400/30 dark:text-yellow-400
           w-btn h-btn text-xl flex justify-center items-center
           rounded-lg cursor-pointer transition-all relative">
                <div class="absolute -top-0.5 -right-0.5">
            <span class="relative flex size-2.5">
  <span
      class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-c dark:bg-yellow-c opacity-75"></span>
  <span class="absolute inline-flex size-2.5 rounded-full bg-blue-c dark:bg-yellow-c"></span>
</span>
                </div>
                <svg class="w-7 h-7 fill-transparent relative">
                    <use xlink:href="#icon-bell"></use>
                </svg>
            </button>

            <!-- منو -->
            <div
                x-show="menuNotification" x-cloak
                x-transition:enter="transition transform duration-200"
                x-transition:enter-start="scale-75 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transition transform duration-150"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-75 opacity-0"
                class="absolute z-30 top-[110%] left-0
           w-max min-w-[300px] p-5 rounded-2xl
           bg-white border border-border-c dark:bg-gray-700 shadow-2xl"
            >
                <div>
                    <span>هیچ اعلانی وجود ندارد</span>
                    <hr class="w-full text-border-c">
                    <ul class="w-full flex flex-col gap-2.5 *:p-2.5 pt-2.5">
                        <li class="*:w-full *:h-full *:cursor-pointer bg-green-500/20 rounded-lg"><a href="#"
                                                                                                     class="flex gap-x-2">
                                <svg class="w-6 h-6 fill-transparent">
                                    <use xlink:href="#icon-check-circle"></use>
                                </svg>
                                <span>لیست فیلم ها</span></a></li>
                        <li class="*:w-full *:h-full *:cursor-pointer bg-red-500/20 rounded-lg"><a href="#"
                                                                                                   class="flex gap-x-2">
                                <svg class="w-6 h-6 fill-transparent">
                                    <use xlink:href="#icon-close-circle"></use>
                                </svg>
                                <span>لیست فیلم ها</span></a></li>
                        <li class="*:w-full *:h-full *:cursor-pointer bg-yellow-500/20 rounded-lg"><a href="#"
                                                                                                      class="flex gap-x-2">
                                <svg class="w-6 h-6 fill-transparent">
                                    <use xlink:href="#icon-danger-circle"></use>
                                </svg>
                                <span>لیست فیلم ها</span></a></li>
                        <li class="*:w-full *:h-full *:cursor-pointer bg-blue-500/20 rounded-lg"><a href="#"
                                                                                                    class="flex gap-x-2">
                                <svg class="w-6 h-6 fill-transparent">
                                    <use xlink:href="#icon-question-circle"></use>
                                </svg>
                                <span>لیست فیلم ها</span></a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>
