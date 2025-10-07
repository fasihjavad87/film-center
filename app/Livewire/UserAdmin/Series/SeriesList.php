<?php

namespace App\Livewire\UserAdmin\Series;


use App\Models\Series;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class SeriesList extends Component
{

    use WithPagination;

    public $search = '';
    public $seriesIdToDelete = null;
    public $seriesNameToDelete = '';



    public function openDeleteModal($seriesId , $seriesName)
    {
        $this->seriesIdToDelete = $seriesId;
        $this->seriesNameToDelete = $seriesName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $series = Series::find($this->seriesIdToDelete);
        if ($series) {
            $series->delete();

            $this->dispatch('toast-notification', [
                'message' => 'سریال حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->seriesIdToDelete = null;
        $this->seriesNameToDelete = '';
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        $series = Series::query()
            ->with('details')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.user-admin.series.series-list' , ['series' => $series]);
    }
}
