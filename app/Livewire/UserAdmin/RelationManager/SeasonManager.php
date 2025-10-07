<?php

namespace App\Livewire\UserAdmin\RelationManager;

use App\Models\Season;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SeasonManager extends Component
{


    public $seasonableId;

    public $seasons = [];
    public $text;

    // فرم
    public $editingSeasonId = null;
    public $season_title, $season_number, $season_description , $season_status;
//    public $source_type_trailer; // trailer-file یا trailer-url
//    public $trailer_url, $trailer_file;

    // مدال‌ها
    public $deleteSeasonId = null;
    public $seasonNameToDelete = '';

    public function mount($seasonableId)
    {
        $this->seasonableId = $seasonableId;
        $this->loadSeasons();
    }

    public function loadSeasons()
    {
        $this->seasons = Season::where('series_id', $this->seasonableId)
            ->get();
    }

    public function openAddSeasonModal()
    {
        $this->resetSeasonForm(); // فرم پاک می‌شود
        $this->dispatch('open-season-modal');
    }

    public function editSeason($id)
    {
        $season = Season::findOrFail($id);

        $this->editingSeasonId = $id;
        $this->season_title = $season->title;
        $this->season_number = $season->season_number;
        $this->season_description = $season->description;
        $this->season_status = $season->status;

        $this->dispatch('open-season-modal');
    }

    public function saveSeason()
    {
        $data = $this->validate([
            'season_title' => 'required|string|max:255',
            'season_number' => 'required|integer',
            'season_description' => 'required',
            'season_status' => 'required|in:ongoing,ended',
        ]);

        // نگاشت view به دیتابیس
        $payload = [
            'series_id' => $this->seasonableId,
            'title' => $this->season_title,
            'season_number' => $this->season_number,
            'description' => $this->season_description,
            'status' => $this->season_status,
        ];

        if ($this->editingSeasonId) {
            Season::find($this->editingSeasonId)->update($payload);
            $this->text = 'فصل ویرایش شد.';
        } else {
            Season::create($payload);
            $this->text = 'فصل ایجاد شد.';
        }

        $this->resetSeasonForm();
        $this->dispatch('close-season-modal');
        $this->dispatch('toast-notification', [
            'message' => $this->text,
            'duration' => 5000
        ]);
        $this->loadSeasons();
    }

    public function openDeleteSeasonModal($id , $seasonName)
    {
        $this->deleteSeasonId = $id;
        $this->seasonNameToDelete = $seasonName;
        $this->dispatch('show-season-delete-modal');
    }

    public function deleteSeason()
    {
        Season::find($this->deleteSeasonId)?->delete();
        $this->deleteSeasonId = null;
        $this->dispatch('toast-notification', [
            'message' => 'فصل حذف شد.',
            'duration' => 5000
        ]);
        $this->dispatch('close-season-delete-modal');
        $this->loadSeasons();
        $this->deleteSeasonId = null;
        $this->seasonNameToDelete = '';
    }


    public function resetSeasonForm()
    {
        $this->editingSeasonId = null;
        $this->season_title = '';
        $this->season_number = '';
        $this->season_description = '';
        $this->season_status = '';
    }


    public function render():View
    {
        return view('livewire.user-admin.relation-manager.season-manager');
    }
}
