<?php

namespace App\Livewire\UserAdmin\Movies;

use App\Models\Category;
use App\Models\Countries;
use App\Models\Movies;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MovieEdite extends Component
{

    use WithFileUploads, WithPagination;

    public $movie; // نگهداری مدل فیلم
    public $title, $e_name, $slug, $status, $description, $runtime;
    public $categories = [], $countries = [];
    public $source_type, $movie_url, $movie_file;
    public $imdb_id, $imdb_rating, $release_year, $language, $age_rating, $poster;
    public $currentPoster;



    // متد mount برای بارگذاری اطلاعات
    public function mount(Movies $movie)
    {
        $this->movie = $movie;
        $this->title = $movie->title;
        $this->e_name = $movie->e_name;
        $this->slug = $movie->slug;
        $this->status = $movie->status;
        $this->description = $movie->description;
        $this->runtime = $movie->runtime;
        if ($movie->movie_url) {
            $this->source_type = 'url';
            $this->movie_url = $movie->movie_url;
        } elseif ($movie->movie_file) {
            $this->source_type = 'file';
            $this->movie_file = $movie->movie_file;
        } else {
            $this->source_type = null; // هیچ چیزی انتخاب نشده
        }
//        $this->source_type = $movie->source_type;
//        $this->movie_url = $movie->movie_url;
//        $this->movie_file = $movie->movie_file;

        // **بررسی وجود رابطه details قبل از دسترسی**
        if ($movie->details) {
            $this->imdb_id = $movie->details->imdb_id;
            $this->imdb_rating = $movie->details->imdb_rating;
            $this->release_year = $movie->details->release_year;
            $this->language = $movie->details->language;
            $this->age_rating = $movie->details->age_rating;
            $this->currentPoster = $movie->details->poster; // برای نمایش پوستر فعلی
        } else {
            // اگر جزئیات وجود نداشت، مقادیر پیش‌فرض را تنظیم کن
            $this->imdb_id = null;
            $this->imdb_rating = null;
            $this->release_year = null;
            $this->language = null;
            $this->age_rating = null;
            $this->currentPoster = null;
        }

        // بارگذاری دسته‌بندی‌ها و کشورها
        $this->categories = $movie->categories->pluck('id')->toArray();
        $this->countries = $movie->countries->pluck('id')->toArray();

    }

    public function updatedEName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        // اعتبار سنجی
        $rules = [
            'title' => 'required|string',
            'e_name' => 'required|string',
            'slug' => 'required|unique:movies,slug,' . $this->movie->id, // تغییر کلیدی
            'status' => 'required|in:active,inactive',
            'description' => 'required|string',
            'runtime' => 'required|numeric',
            'categories' => 'required|array',
            'countries' => 'required|array',
            'source_type' => 'required|in:url,file',
            'poster' => 'nullable|image|max:1024', // تغییر: nullable
            'imdb_id' => 'required|string',
            'imdb_rating' => 'required|numeric|min:0|max:10',
            'release_year' => 'required|integer',
            'language' => 'required|string',
            'age_rating' => 'required|string',
        ];

        if ($this->poster instanceof \Illuminate\Http\UploadedFile) {
            $rules['poster'] = 'required|image|max:1024';
        }


        $this->validate($rules);

        // به‌روزرسانی اطلاعات فیلم
        $this->movie->update([
            'title' => $this->title,
            'e_name' => $this->e_name,
            'slug' => $this->slug,
            'status' => $this->status,
            'description' => $this->description,
            'runtime' => $this->runtime,
            'movie_url' => $this->source_type === 'url' ? $this->movie_url : null,
            'movie_file' => $this->source_type === 'file' && !is_string($this->movie_file)
                ? $this->movie_file->store('movies', 'filament')
                : $this->movie->movie_file,
        ]);

        $this->movie->categories()->sync($this->categories);
        $this->movie->countries()->sync($this->countries);

        // آپلود پوستر (فقط اگر فایل جدید بود)
        $posterPath = $this->currentPoster; // پیش‌فرض همون قبلی
        if ($this->poster instanceof \Illuminate\Http\UploadedFile) {
            $posterPath = $this->poster->store('poster_movies', 'filament');
        }

        $this->movie->details()->update([
            'imdb_id' => $this->imdb_id,
            'imdb_rating' => $this->imdb_rating,
            'release_year' => $this->release_year,
            'language' => $this->language,
            'age_rating' => $this->age_rating,
            'poster' => $posterPath,
        ]);

        return redirect()->route('panelAdmin.movies.index');
//        return $this->redirect(route('panelAdmin.movies.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {

        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.movies.movie-edite', [
            'allCategories' => Category::all(),
            'allCountries' => Countries::all(),
            'years' => range(1970, now()->addYears(6)->year),
        ]);
    }
}
