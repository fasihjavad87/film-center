<section
    class="fixed top-0 md:top-app-header-h -right-app-sidebar-w md:right-0 w-app-sidebar-w pb-0 md:pb-app-header-h  z-50 md:z-20 overflow-y-auto h-screen border-l border-border-c bg-white dark:bg-gray-700 dark:text-white md:block transition-[right]"
    :class="sidebarOpen ? 'right-0' : '-right-app-sidebar-w'" dir="ltr">
    <div class="flex justify-between items-start p-3 md:p-7" dir="rtl">
        <span>Sidebar</span>
        <button
            class="bg-white dark:bg-gray-800 dark:text-yellow-400 w-30 h-30 flex justify-center items-center rounded-lg md:hidden"
            @click="sidebarOpen = false"><i class="fa-regular fa-xmark"></i></button>
    </div>
    <div dir="rtl" class="bg-white mx-2.5 px-3 py-4 rounded-lg flex gap-x-5 items-center border border-border-c dark:bg-gray-800 ">
        <img class="rounded-full w-14 h-14" src="{{ asset('uploads/' . $avatar) }}">
        <div class="w-full flex flex-col gap-y-2.5">
            <a href="#" class="text-black dark:text-white flex items-center justify-between transition-all hover:text-blue-c dark:hover:text-yellow-c"><span class="font-normal">{{ $name }}</span><i class="fa-regular fa-angle-left"></i></a>
            <hr class="w-full text-border-c -mr-1">
            <a class="text-black dark:text-white flex items-center justify-between"><span class="font-normal">اشتراک</span><span class="text-sm font-normal px-2 py-1px  bg-green-500 text-white  rounded-sm">دارید</span></a>
        </div>
    </div>
    <div class="px-2.5 py-5" dir="rtl">
        <ul class="flex flex-col gap-y-2.5">
            <li><a href="{{ route('panelAdmin.users.index') }}" class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.users.index') ? 'panel-user-item-sidebar-active' : '' }}"><svg class="w-6 h-6 fill-transparent">
                        <use xlink:href="#icon-user"></use>
                    </svg> <span class="pt-3px">کاربران</span></a></li>
            <li><a href="{{ route('panelAdmin.categories.index') }}" class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.categories.index') ? 'panel-user-item-sidebar-active' : '' }}"><svg class="w-6 h-6 fill-transparent">
                        <use xlink:href="#icon-library"></use>
                    </svg> <span class="pt-3px">دسته بندی ها</span></a></li>
            <li><a href="{{ route('panelAdmin.countries.index') }}" class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.countries.index') ? 'panel-user-item-sidebar-active' : '' }}"><svg class="w-6 h-6 fill-transparent">
                        <use xlink:href="#icon-global"></use>
                    </svg> <span class="pt-3px">کشور ها</span></a></li>
            <li><a href="#" class="panel-user-item-sidebar {{ request()->routeIs('panelAdmin.dashboard') ? 'panel-user-item-sidebar-active' : '' }}"><svg class="w-6 h-6 fill-transparent">
                        <use xlink:href="#icon-dashboard"></use>
                    </svg> <span class="pt-3px">داشبورد</span></a></li>
{{--            <li><a href="#" class="panel-user-item-sidebar"><svg class="w-6 h-6 fill-transparent">--}}
{{--                        <use xlink:href="#icon-save"></use>--}}
{{--                    </svg> <span class="pt-3px">علاقه مندی ها</span></a></li>--}}
{{--            <li><a href="#" class="panel-user-item-sidebar"><svg class="w-6 h-6 fill-transparent">--}}
{{--                        <use xlink:href="#icon-payment-history"></use>--}}
{{--                    </svg> <span class="pt-3px">سوابق خرید</span></a></li>--}}
{{--            <li><a href="{{ route('panel.tickets.index') }}" class="panel-user-item-sidebar"><svg class="w-6 h-6 fill-transparent">--}}
{{--                        <use xlink:href="#icon-ticket"></use>--}}
{{--                    </svg> <span class="pt-3px">تیکت ها</span></a></li>--}}
{{--            <li><a href="#" class="panel-user-item-sidebar justify-between"><div class="flex gap-x-2.5"><svg class="w-6 h-6 fill-transparent">--}}
{{--                            <use xlink:href="#icon-wallet"></use>--}}
{{--                        </svg> <span>کیف پول</span></div><div class="flex gap-x-0.5"><span>0</span><span>تومان</span></div></a></li>--}}
{{--            <li><a href="#" class="panel-user-item-sidebar"><svg class="w-6 h-6 fill-transparent">--}}
{{--                        <use xlink:href="#icon-profile"></use>--}}
{{--                    </svg> <span class="pt-3px">اطلاعات حساب</span></a></li>--}}
{{--            <li><a href="#" class="panel-user-item-sidebar relative">--}}
{{--                    <div class="absolute -top-0.5 -right-0.5">--}}
{{--            <span class="relative flex size-2.5">--}}
{{--  <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-c dark:bg-yellow-c opacity-75"></span>--}}
{{--  <span class="absolute inline-flex size-2.5 rounded-full bg-blue-c dark:bg-yellow-c"></span>--}}
{{--</span>--}}
{{--                    </div>--}}
{{--                    <svg class="w-6 h-6 fill-transparent relative">--}}
{{--                        <use xlink:href="#icon-bell"></use>--}}
{{--                    </svg> <span class="pt-3px">اعلان ها</span></a></li>--}}
{{--            <li><a href="#" class="panel-user-item-sidebar"><svg class="w-6 h-6 fill-transparent">--}}
{{--                        <use xlink:href="#icon-monitor-smartphone"></use>--}}
{{--                    </svg> <span class="pt-3px">دستگاه های فعال</span></a></li>--}}
{{--            <li><a href="#" class="panel-user-item-sidebar"><svg class="w-6 h-6 fill-transparent">--}}
{{--                        <use xlink:href="#icon-crown"></use>--}}
{{--                    </svg> <span class="pt-3px">خرید اشتراک</span></a></li>--}}
            <hr class="w-full text-blue-c dark:text-yellow-c my-1">
            <li><a href="{{ route('logout') }}" class="panel-user-item-sidebar-power"><svg class="w-6 h-6 -rotate-45 fill-transparent">
                        <use xlink:href="#icon-power"></use>
                    </svg> <span class="pt-3px">خروج از حساب کاربری</span></a></li>
        </ul>
    </div>
</section>
