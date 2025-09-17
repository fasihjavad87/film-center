<?php

namespace App\Livewire\UserAdmin\Series;

use App\Models\Category;
use App\Models\Countries;
use App\Models\Series;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SeriesEdite extends Component
{

    use WithFileUploads, WithPagination;

    public $series; // نگهداری مدل فیلم
    public $title, $e_name, $slug, $description;
    public $categories = [], $countries = [];
//    public $source_type, $movie_url, $movie_file;
    public $imdb_id, $imdb_rating, $release_year, $language, $age_rating, $poster;
    public $currentPoster;



    // متد mount برای بارگذاری اطلاعات
    public function mount(Series $series)
    {
        $this->series = $series;
        $this->title = $series->title;
        $this->e_name = $series->e_name;
        $this->slug = $series->slug;
        $this->description = $series->description;
//        if ($movie->movie_url) {
//            $this->source_type = 'url';
//            $this->movie_url = $movie->movie_url;
//        } elseif ($movie->movie_file) {
//            $this->source_type = 'file';
//            $this->movie_file = $movie->movie_file;
//        } else {
//            $this->source_type = null; // هیچ چیزی انتخاب نشده
//        }
//        $this->source_type = $movie->source_type;
//        $this->movie_url = $movie->movie_url;
//        $this->movie_file = $movie->movie_file;

        // **بررسی وجود رابطه details قبل از دسترسی**
        if ($series->details) {
            $this->imdb_id = $series->details->imdb_id;
            $this->imdb_rating = $series->details->imdb_rating;
            $this->release_year = $series->details->release_year;
            $this->language = $series->details->language;
            $this->age_rating = $series->details->age_rating;
            $this->currentPoster = $series->details->poster; // برای نمایش پوستر فعلی
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
        $this->categories = $series->categories->pluck('id')->toArray();
        $this->countries = $series->countries->pluck('id')->toArray();

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
            'slug' => 'required|unique:series,slug,' . $this->series->id, // تغییر کلیدی
            'description' => 'required|string',
            'categories' => 'required|array',
            'countries' => 'required|array',
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
        $this->series->update([
            'title' => $this->title,
            'e_name' => $this->e_name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        $this->series->categories()->sync($this->categories);
        $this->series->countries()->sync($this->countries);

        // آپلود پوستر (فقط اگر فایل جدید بود)
        $posterPath = $this->currentPoster; // پیش‌فرض همون قبلی
        if ($this->poster instanceof \Illuminate\Http\UploadedFile) {
            $posterPath = $this->poster->store('poster_series', 'filament');
        }

        $this->series->details()->update([
            'imdb_id' => $this->imdb_id,
            'imdb_rating' => $this->imdb_rating,
            'release_year' => $this->release_year,
            'language' => $this->language,
            'age_rating' => $this->age_rating,
            'poster' => $posterPath,
        ]);

//        return redirect()->route('panelAdmin.series.index');
        return $this->redirect(route('panelAdmin.series.index'), navigate: true);
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.series.series-edite', [
            'allCategories' => Category::all(),
            'allCountries' => Countries::all(),
            'years' => range(1970, now()->addYears(6)->year),
        ]);
    }
}
