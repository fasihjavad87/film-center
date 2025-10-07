<?php

namespace App\Livewire\Panel\ActiveDevices;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ActiveDeviceList extends Component
{
    public $sessions = [];
    public $sessionIdToDelete = null;

    public function mount()
    {
        $this->loadActiveSessions();
    }

    public function loadActiveSessions()
    {
        $currentSessionId = Session::getId();
        $userId = Auth::id();

        // سشن‌های کاربر به جز سشن فعلی
        $sessions = DB::table('sessions')
            ->where('user_id', $userId)
            ->where('id', '!=', $currentSessionId)
            ->orderBy('last_activity', 'desc')
            ->get();

        $processedSessions = $sessions->map(function ($session) {
            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);

            return (object) [
                'id' => $session->id,
                'ip_address' => $session->ip_address,
                'is_current' => false,
                'browser' => $agent->browser() ?? 'نامشخص',
                'os' => $agent->platform() ?? 'نامشخص',
                'device' => $agent->device() ?: 'Unknown Device',
                'last_active_at' => verta()->createTimestamp($session->last_activity)->format('Y/m/d H:i'),
            ];
        });

        // سشن فعلی
        $currentAgent = new Agent();
        $currentAgent->setUserAgent(request()->header('User-Agent'));

        $currentSession = (object) [
            'id' => $currentSessionId,
            'ip_address' => request()->ip(),
            'is_current' => true,
            'browser' => $currentAgent->browser() ?? 'نامشخص',
            'os' => $currentAgent->platform() ?? 'نامشخص',
            'device' => $currentAgent->device() ?: 'Unknown Device',
            'last_active_at' => verta()->createTimestamp(time())->format('Y/m/d H:i'),
        ];

        $this->sessions = collect([$currentSession])->merge($processedSessions);
    }

//    public function deleteSession($sessionId)
//    {
//        if ($sessionId === Session::getId()) {
//            $this->dispatch('notify', message: 'شما نمی‌توانید نشست فعال خود را حذف کنید.', type: 'error');
//            return;
//        }
//
//        DB::table('sessions')->where('id', $sessionId)->delete();
//
//        $this->loadActiveSessions();
//
//        $this->dispatch('notify', message: 'دستگاه با موفقیت از سیستم خارج شد.', type: 'success');
//    }

    public function openDeleteModal($sessionId)
    {
        if ($sessionId === Session::getId()) {
//            $this->dispatch('notify', message: 'شما نمی‌توانید نشست فعال خود را حذف کنید.', type: 'error');
            $this->dispatch('toast-notification', [
                'message' => 'شما نمی‌توانید نشست فعال خود را حذف کنید.',
                'duration' => 5000
            ]);
            return;
        }
        $this->sessionIdToDelete = $sessionId;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $session = DB::table('sessions')->where('id', $this->sessionIdToDelete);
        if ($session) {
            $session->delete();

            $this->loadActiveSessions();

            $this->dispatch('toast-notification', [
                'message' => 'دستگاه با موفقیت از سیستم خارج شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
    }

    #[Layout('panel.master')]
    public function render(): View
    {
        return view('livewire.panel.active-devices.active-device-list');
    }
}
