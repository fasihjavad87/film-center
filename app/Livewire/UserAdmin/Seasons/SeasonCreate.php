<?php

namespace App\Livewire\UserAdmin\Seasons;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SeasonCreate extends Component
{


    public $series_id = null , $title, $season_number, $description , $status;


    public function save()
    {
//        if (is_array($this->release_year)) {
//            // اگر آرایه بود، اولین مقدار انتخابی رو بگیر
//            $this->release_year = (int) ($this->release_year[0] ?? null);
//        } else {
//            $this->release_year = (int) $this->release_year;
//        }
        $this->validate([
            'series_id' => 'required|integer',
            'title' => 'required|string',
            'season_number' => 'required|integer',
            'description' => 'required',
            'status' => 'required|in:ongoing,ended',
        ]);

//        dd([
//            'series_id'       => $this->series_id,
//            'title'       => $this->title,
//            'season_number'       => $this->season_number,
//            'description'       => $this->description,
//            'status'       => $this->status,
//        ]);


        $season = Season::create([
            'series_id' => $this->series_id,
            'title' => $this->title,
            'season_number' => $this->season_number,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        return redirect()->route('panelAdmin.seasons.index');
//        return $this->redirect(route('panelAdmin.seasons.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        $series = Series::select('id', 'title')->get();
        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.seasons.season-create', ['series' => $series]);
    }
}
