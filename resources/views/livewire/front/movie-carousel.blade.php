<div class="movie-carousel grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
    @foreach($movies as $movie)
        <div class="movie-card bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
            <a href="{{ route('site.movie.show', $movie->slug) }}" wire:navigate>

                {{-- فرض می‌کنیم یک فیلد 'poster_url' در مدل Movie دارید --}}
                <img src="{{ $movie->poster_url ?? 'https://placehold.co/300x450' }}"
                     alt="{{ $movie->title }}"
                     class="w-full h-auto object-cover aspect-[2/3]">

                <div class="p-3 text-center">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white truncate" title="{{ $movie->title }}">
                        {{ $movie->title }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ $movie->release_year }} | امتیاز: {{ number_format($movie->rating, 1) }}
                    </p>
                </div>
            </a>
        </div>
    @endforeach
</div>
