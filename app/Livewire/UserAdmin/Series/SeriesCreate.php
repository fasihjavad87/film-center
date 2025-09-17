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

class SeriesCreate extends Component
{

    use WithFileUploads;

    public $title, $e_name, $slug, $description;
    public $categories = [], $countries = [];
//    public $source_type = 'url', $movie_url, $movie_file;
    public $imdb_id, $imdb_rating, $release_year, $language, $age_rating, $poster;

    public function updatedEName($value)
    {
        $this->slug = Str::slug($value);
    }


    public function save()
    {
        if (is_array($this->release_year)) {
            // اگر آرایه بود، اولین مقدار انتخابی رو بگیر
            $this->release_year = (int) ($this->release_year[0] ?? null);
        } else {
            $this->release_year = (int) $this->release_year;
        }
        $this->validate([
            'title' => 'required|string',
            'e_name' => 'required|string',
            'slug' => 'required|unique:movies,slug',
            'description' => 'required|string',
            'categories' => 'required|array',
            'countries' => 'required|array',
//            'source_type' => 'required|in:url,file',
            'poster' => 'required|image|max:1024',
            'imdb_id' => 'required|string',
            'imdb_rating' => 'required|numeric|min:0|max:10',
            'release_year' => 'required|integer',
            'language' => 'required|string',
            'age_rating' => 'required|string',
        ]);

//        dd([
//            'title'       => $this->title,
//            'e_name'      => $this->e_name,
//            'slug'        => $this->slug,
//            'status'      => $this->status,
//            'description' => $this->description,
//            'runtime'     => $this->runtime,
//            'movie_url'   => $this->source_type === 'url' ? $this->movie_url : null,
//            'movie_file'  => $this->source_type === 'file' ? $this->movie_file : null,
//            'categories'  => $this->categories,
//            'countries'   => $this->countries,
//            'imdb_id'     => $this->imdb_id,
//            'imdb_rating' => $this->imdb_rating,
//            'release_year'=> $this->release_year,
//            'language'    => $this->language,
//            'age_rating'  => $this->age_rating,
//            'poster'      => $this->poster,
//        ]);


        $series = Series::create([
            'title' => $this->title,
            'e_name' => $this->e_name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        $series->categories()->sync($this->categories);
        $series->countries()->sync($this->countries);

        // ذخیره اطلاعات جدول movie_details
        $series->details()->create([
            'imdb_id' => $this->imdb_id,
            'imdb_rating' => $this->imdb_rating,
            'release_year' => $this->release_year,
            'language' => $this->language,
            'age_rating' => $this->age_rating,
            'poster' => $this->poster->store('poster_movies', 'filament'),
        ]);

//        return redirect()->route('panelAdmin.movies.index');
        return $this->redirect(route('panelAdmin.series.index'), navigate: true);

    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.series.series-create', [
            'allCategories' => Category::all(),
            'allCountries' => Countries::all(),
            'years' => range(1970, now()->addYears(6)->year),
        ]);
    }
}
