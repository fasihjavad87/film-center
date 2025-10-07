<?php

namespace App\Livewire\UserAdmin\RelationManager;

use App\Models\Episode;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class EpisodeManager extends Component
{

    use WithFileUploads;

    public $episodeableId;

    public $episodes = [];
    public $text;

    // فرم
    public $editingEpisodeId = null;
    public $episode_title, $episode_number, $episode_runtime;
    public $source_type_episode; // trailer-file یا trailer-url
    public $episode_url, $episode_file;

    // مدال‌ها
    public $deleteEpisodeId = null;
    public $episodeNameToDelete = '';

    public function mount($episodeableId)
    {
        $this->episodeableId = $episodeableId;
        $this->loadEpisodes();
    }

    public function loadEpisodes()
    {
        $this->episodes = Episode::with('season.series')
            ->where('season_id', $this->episodeableId)
            ->get();
    }

    public function openAddModal()
    {
        $this->resetForm(); // فرم پاک می‌شود
        $this->dispatch('open-episode-modal');
    }

    public function editEpisode($id)
    {
        $episode = Episode::findOrFail($id);

        $this->editingEpisodeId = $id;
        $this->episode_title = $episode->title;
        $this->episode_number = $episode->episode_number;
        $this->episode_runtime = $episode->runtime;

        // نگاشت به radio button
        if ($episode->episode_url) {
            $this->source_type_episode = 'episode-url';
            $this->episode_url = $episode->episode_url;
            $this->episode_file = null;
        } elseif ($episode->episode_file) {
            $this->source_type_episode = 'episode-file';
            $this->episode_file = $episode->episode_file;
            $this->episode_url = null;
        } else {
            $this->source_type_episode = null;
            $this->episode_url = $this->episode_file = null;
        }

        $this->dispatch('open-episode-modal');
    }

    public function saveEpisode()
    {
        $data = $this->validate([
            'episode_title' => 'required|string|max:255',
            'episode_number' => 'integer',
            'episode_runtime' => 'integer',
            'source_type_episode' => 'required|in:episode-file,episode-url',
            'episode_url' => 'nullable|string',
            'episode_file' => 'nullable',
        ]);

        // نگاشت view به دیتابیس
        $payload = [
            'season_id' => $this->episodeableId,
            'title' => $this->episode_title,
            'episode_number' => $this->episode_number,
            'runtime' => $this->episode_runtime,
            'episode_url' => $this->source_type_episode === 'episode-url' ? $this->episode_url : null,
            'episode_file' => $this->source_type_episode === 'episode-file' && $this->episode_file ? $this->episode_file->store('series_episode', 'filament') : null,
        ];

        if ($this->editingEpisodeId) {
            Episode::find($this->editingEpisodeId)->update($payload);
            $this->text = 'قسمت ویرایش شد.';
        } else {
            Episode::create($payload);
            $this->text = 'قسمت ایجاد شد.';
        }

        $this->resetForm();
        $this->dispatch('close-episode-modal');
        $this->dispatch('toast-notification', [
            'message' => $this->text,
            'duration' => 5000
        ]);
        $this->loadEpisodes();
    }

    public function openDeleteModal($id , $episodeName)
    {
        $this->deleteEpisodeId = $id;
        $this->episodeNameToDelete = $episodeName;
        $this->dispatch('show-episode-delete-modal');
    }

    public function delete()
    {
        Episode::find($this->deleteEpisodeId)?->delete();
        $this->deleteEpisodeId = null;
        $this->dispatch('toast-notification', [
            'message' => 'قسمت حذف شد.',
            'duration' => 5000
        ]);
        $this->dispatch('close-episode-delete-modal');
        $this->loadEpisodes();
        $this->deleteEpisodeId = null;
        $this->episodeNameToDelete = '';
    }


    public function resetForm()
    {
        $this->editingEpisodeId = null;
        $this->episode_title = '';
        $this->episode_number = '';
        $this->episode_runtime = '';
        $this->source_type_episode = 'episode-url';
        $this->episode_url = '';
        $this->episode_file = null;
    }


    public function render():View
    {
        return view('livewire.user-admin.relation-manager.episode-manager');
    }
}
