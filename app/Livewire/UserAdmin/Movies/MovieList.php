<?php

namespace App\Livewire\UserAdmin\Movies;


use App\Models\Movies;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class MovieList extends Component
{

    use WithPagination;

    public $search = '';
    public $movieIdToDelete = null;
    public $movieNameToDelete = '';



    public function openDeleteModal($movieId , $movieName)
    {
        $this->movieIdToDelete = $movieId;
        $this->movieNameToDelete = $movieName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $movie = Movies::find($this->movieIdToDelete);
        if ($movie) {
            $movie->delete();

            $this->dispatch('toast-notification', [
                'message' => 'فیلم حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->movieIdToDelete = null;
        $this->movieNameToDelete = '';
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $movies = Movies::query()
            ->with('details')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.user-admin.movies.movie-list', ['movies' => $movies]);
    }
}
