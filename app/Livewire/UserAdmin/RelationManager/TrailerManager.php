<?php

namespace App\Livewire\UserAdmin\RelationManager;

use App\Models\Trailers;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class TrailerManager extends Component
{
    use WithFileUploads;

    public $trailerableId;
    public $trailerableType;

    public $trailers = [];
    public $text;

    // فرم
    public $editingTrailerId = null;
    public $trailer_title, $trailer_order, $trailer_duration;
    public $source_type_trailer; // trailer-file یا trailer-url
    public $trailer_url, $trailer_file;

    // مدال‌ها
    public $deleteTrailerId = null;
    public $trailerNameToDelete = '';

    public function mount($trailerableId, $trailerableType)
    {
        $this->trailerableId = $trailerableId;
        $this->trailerableType = $trailerableType;
        $this->loadTrailers();
    }

    public function loadTrailers()
    {
        $this->trailers = Trailers::where('trailerable_id', $this->trailerableId)
            ->where('trailerable_type', $this->trailerableType)
            ->get();
    }

    public function openAddModal()
    {
        $this->resetForm(); // فرم پاک می‌شود
        $this->dispatch('open-trailer-modal');
    }

    public function editTrailer($id)
    {
        $trailer = Trailers::findOrFail($id);

        $this->editingTrailerId = $id;
        $this->trailer_title = $trailer->title;
        $this->trailer_order = $trailer->order;
        $this->trailer_duration = $trailer->duration;

        // نگاشت به radio button
        if ($trailer->video_url) {
            $this->source_type_trailer = 'trailer-url';
            $this->trailer_url = $trailer->video_url;
            $this->trailer_file = null;
        } elseif ($trailer->video_file) {
            $this->source_type_trailer = 'trailer-file';
            $this->trailer_file = $trailer->video_file;
            $this->trailer_url = null;
        } else {
            $this->source_type_trailer = null;
            $this->trailer_url = $this->trailer_file = null;
        }

        $this->dispatch('open-trailer-modal');
    }

    public function saveTrailer()
    {
        $data = $this->validate([
            'trailer_title' => 'required|string|max:255',
            'trailer_order' => 'nullable|integer',
            'trailer_duration' => 'nullable|integer|max:255',
            'source_type_trailer' => 'required|in:trailer-file,trailer-url',
            'trailer_url' => 'nullable|string',
            'trailer_file' => 'nullable',
        ]);

        // نگاشت view به دیتابیس
        $payload = [
            'trailerable_id' => $this->trailerableId,
            'trailerable_type' => $this->trailerableType,
            'title' => $this->trailer_title,
            'order' => $this->trailer_order,
            'duration' => $this->trailer_duration,
            'video_url' => $this->source_type_trailer === 'trailer-url' ? $this->trailer_url : null,
            'video_file' => $this->source_type_trailer === 'trailer-file' && $this->trailer_file ? $this->trailer_file->store('trailers', 'filament') : null,
        ];

        if ($this->editingTrailerId) {
            Trailers::find($this->editingTrailerId)->update($payload);
            $this->text = 'تیزر ویرایش شد.';
        } else {
            Trailers::create($payload);
            $this->text = 'تیزر ایجاد شد.';
        }

        $this->resetForm();
        $this->dispatch('close-trailer-modal');
        $this->dispatch('toast-notification', [
            'message' => $this->text,
            'duration' => 5000
        ]);
        $this->loadTrailers();
    }

    public function openDeleteModal($id , $trailerName)
    {
        $this->deleteTrailerId = $id;
        $this->trailerNameToDelete = $trailerName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        Trailers::find($this->deleteTrailerId)?->delete();
        $this->deleteTrailerId = null;
        $this->dispatch('toast-notification', [
            'message' => 'تیزر حذف شد.',
            'duration' => 5000
        ]);
        $this->dispatch('close-delete-modal');
        $this->loadTrailers();
        $this->deleteTrailerId = null;
        $this->trailerNameToDelete = '';
    }


    public function resetForm()
    {
        $this->editingTrailerId = null;
        $this->trailer_title = '';
        $this->trailer_order = '';
        $this->trailer_duration = '';
        $this->source_type_trailer = 'trailer-url';
        $this->trailer_url = '';
        $this->trailer_file = null;
    }

    public function render(): View
    {
        return view('livewire.user-admin.relation-manager.trailer-manager');
    }
}
