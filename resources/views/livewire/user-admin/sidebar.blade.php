<section
    class="fixed top-0 md:top-app-header-h -right-app-sidebar-w md:right-0 w-app-sidebar-w pb-0 md:pb-app-header-h  z-50 md:z-20 overflow-y-auto h-screen border-l border-border-c bg-white dark:bg-gray-700 dark:text-white md:block transition-[right]"
    :class="sidebarOpen ? 'right-0' : '-right-app-sidebar-w'" dir="ltr">
    <div class="flex justify-between items-start p-3 md:p-7" dir="rtl">
        <span>Sidebar</span>
        <button
            class="bg-white dark:bg-gray-800 dark:text-yellow-400 w-30 h-30 flex justify-center items-center rounded-lg md:hidden"
            @click="sidebarOpen = false"><i class="fa-regular fa-xmark"></i></button>
    </div>
    <div dir="rtl"
         class="bg-white mx-2.5 px-3 py-4 rounded-lg flex gap-x-5 items-center border border-border-c dark:bg-gray-800 ">
        <img class="rounded-full w-14 h-14" src="{{ asset('uploads/' . $avatar) }}">
        <div class="w-full flex flex-col gap-y-2.5">
            <a href="#"
               class="text-black dark:text-white flex items-center justify-between transition-all hover:text-blue-c dark:hover:text-yellow-c"><span
                    class="font-normal">{{ $name }}</span><i class="fa-regular fa-angle-left"></i></a>
            <hr class="w-full text-border-c -mr-1">
            <a class="text-black dark:text-white flex items-center justify-between"><span
                    class="font-normal">اشتراک</span><span
                    class="text-sm font-normal px-2 py-1px  bg-green-500 text-white  rounded-sm">دارید</span></a>
        </div>
    </div>
    <div class="px-2.5 py-5" dir="rtl">
        <ul class="flex flex-col gap-y-2.5">
            @if(auth()->user()->isAdmin('show-user'))
                <li><a href="{{ route('panelAdmin.users.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.users.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-user"></use>
                        </svg>
                        <span class="pt-3px">کاربران</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-role'))
                <li><a href="{{ route('panelAdmin.roles.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.roles.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-shield-user"></use>
                        </svg>
                        <span class="pt-3px">نقش ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-permission'))
                <li><a href="{{ route('panelAdmin.permissions.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.permissions.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-shield-keyhole-minimalistic"></use>
                        </svg>
                        <span class="pt-3px">مجوز ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-category'))
                <li><a href="{{ route('panelAdmin.categories.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.categories.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-library"></use>
                        </svg>
                        <span class="pt-3px">دسته بندی ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-country'))
                <li><a href="{{ route('panelAdmin.countries.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.countries.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-global"></use>
                        </svg>
                        <span class="pt-3px">کشور ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-movie'))
                <li><a href="{{ route('panelAdmin.movies.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.movies.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-video-frame-play-horizontal"></use>
                        </svg>
                        <span class="pt-3px">فیلم ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-series'))
                <li><a href="{{ route('panelAdmin.series.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.series.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-video-frame-play-vertical"></use>
                        </svg>
                        <span class="pt-3px">سریال ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-season'))
                <li><a href="{{ route('panelAdmin.seasons.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.seasons.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-library"></use>
                        </svg>
                        <span class="pt-3px">فصل ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-ticket'))
                <li><a href="{{ route('panelAdmin.tickets.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.tickets.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-ticket"></use>
                        </svg>
                        <span class="pt-3px">تیکت ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-plan'))
                <li><a href="{{ route('panelAdmin.plans.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.plans.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-crown"></use>
                        </svg>
                        <span class="pt-3px">اشتراک ها</span></a></li>
            @endif
            @if(auth()->user()->isAdmin('show-discount-code'))
                <li><a href="{{ route('panelAdmin.discountCodes.index') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.discountCodes.index') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-sale"></use>
                        </svg>
                        <span class="pt-3px">کد های تخفیف</span></a></li>
            @endif
{{--            @if(auth()->user()->isAdmin('show-dashboard'))--}}
                <li><a href="{{ route('panelAdmin.dashboard') }}"
                       class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.dashboard') ? 'panel-user-item-sidebar-active' : '' }}">
                        <svg class="w-6 h-6 fill-transparent">
                            <use xlink:href="#icon-dashboard"></use>
                        </svg>
                        <span class="pt-3px">داشبورد</span></a></li>
{{--            @endif--}}
            <hr class="w-full text-blue-c dark:text-yellow-c my-1">
            <li><a href="{{ route('logout') }}" class="panel-user-item-sidebar-power">
                    <svg class="w-6 h-6 -rotate-45 fill-transparent">
                        <use xlink:href="#icon-power"></use>
                    </svg>
                    <span class="pt-3px">خروج از حساب کاربری</span></a></li>
        </ul>
    </div>
</section>
