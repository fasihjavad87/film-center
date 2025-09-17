<?php

namespace App\Livewire\UserAdmin\Seasons;

use App\Models\Season;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class SeasonList extends Component
{

    use WithPagination;

    public $search = '';
    public $seasonsIdToDelete = null;



    public function openDeleteModal($seasonsId)
    {
        $this->seasonsIdToDelete = $seasonsId;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $seasons = Season::find($this->seasonsIdToDelete);
        if ($seasons) {
            $seasons->delete();

            $this->dispatch('toast-notification', [
                'message' => 'فصل حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $seasons = Season::query()
            ->with('series')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.user-admin.seasons.season-list', ['seasons' => $seasons]);
    }
}
