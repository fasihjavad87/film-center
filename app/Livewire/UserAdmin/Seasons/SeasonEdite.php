<?php

namespace App\Livewire\UserAdmin\Seasons;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SeasonEdite extends Component
{

    public $season;
    public $series_id = null , $title, $season_number, $description , $status;


    public function mount(Season $season)
    {
        $this->season = $season;
        $this->series_id = $season->series_id;
        $this->title = $season->title;
        $this->season_number = $season->season_number;
        $this->description = $season->description;
        $this->status = $season->status;
    }


//    public function save()
//    {
//        $this->validate([
//            'series_id' => 'required|integer',
//            'title' => 'required|string',
//            'season_number' => 'required|integer',
//            'description' => 'required',
//            'status' => 'required|in:ongoing,ended',
//        ]);
//
////        dd([
////            'series_id'       => $this->series_id,
////            'title'       => $this->title,
////            'season_number'       => $this->season_number,
////            'description'       => $this->description,
////            'status'       => $this->status,
////        ]);
//
//
//        $this->season->update([
//            'series_id' => $this->series_id,
//            'title' => $this->title,
//            'season_number' => $this->season_number,
//            'description' => $this->description,
//            'status' => $this->status,
//        ]);
//
//        return redirect()->route('panelAdmin.seasons.index');
//    }
    public function save()
    {
        $this->validate([
            'series_id' => 'required|integer',
            'title' => 'required|string',
            'season_number' => 'required|integer',
            'description' => 'required',
            'status' => 'required|in:ongoing,ended',
        ]);

        $this->season->update([
            'series_id' => $this->series_id,
            'title' => $this->title,
            'season_number' => $this->season_number,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        // emit یک event به فرانت‌اند
        return redirect()->route('panelAdmin.seasons.index');
//        return $this->redirect(route('panelAdmin.seasons.index'), navigate: true);
    }



    #[Layout('panel-admin.master')]
    public function render():View
    {
        $series = Series::select('id', 'title')->get();
        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.seasons.season-edite', ['series' => $series]);
    }
}
