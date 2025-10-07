<div class="animate-pulse grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
    @for($i = 0; $i < 6; $i++)
        <div class="movie-card bg-gray-200 dark:bg-gray-700 rounded-xl overflow-hidden shadow-lg aspect-[2/3]">
            <!-- Placeholder برای پوستر -->
            <div class="w-full h-4/5 bg-gray-300 dark:bg-gray-600"></div>

            <div class="p-3">
                <!-- Placeholder برای عنوان -->
                <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-3/4 mx-auto mb-2"></div>
                <!-- Placeholder برای توضیحات -->
                <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-1/2 mx-auto"></div>
            </div>
        </div>
    @endfor
</div>
