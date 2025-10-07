<?php

namespace App\Livewire\UserAdmin\Tickets;

use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class TicketsList extends Component
{
    use WithPagination;

    public $statusFilter = 'all'; // وضعیت انتخاب شده
    public $deleteTicketId = null;
    public $ticketNameToDelete = '';

    protected $queryString = ['statusFilter']; // حفظ فیلتر در URL

    public function setFilter($status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    // لیست تیکت‌ها
    public function getTicketsProperty()
    {
        $query = Tickets::with(['user', 'lastMessage'])->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return $query->paginate(10);
    }

    // باز کردن مودال حذف
    public function openDeleteTicketModal($id , $ticketName): void
    {
        $this->deleteTicketId = $id;
        $this->ticketNameToDelete = $ticketName;
        $this->dispatch('show-delete-modal');
    }

    // حذف تیکت
    public function deleteTicket(): void
    {
        Tickets::find($this->deleteTicketId)?->delete();

        $this->deleteTicketId = null;

        $this->dispatch('toast-notification', [
            'message' => 'تیکت حذف شد.',
            'duration' => 3000
        ]);

        $this->dispatch('close-trailer-modal');
        $this->resetPage();
        $this->deleteTicketId = null;
        $this->ticketNameToDelete = '';
    }

    #[Layout('panel-admin.master')]
    public function render(): View
    {
        // بهینه‌سازی شمارش‌ها با یک کوئری
        $counts = Tickets::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $counts['all'] = array_sum($counts);

        // مطمئن بشیم کلیدهای لازم همیشه وجود دارن
        foreach (['open', 'answered', 'pending', 'closed'] as $key) {
            $counts[$key] = $counts[$key] ?? 0;
        }

        return view('livewire.user-admin.tickets.tickets-list', [
            'tickets' => $this->tickets,
            'counts' => $counts,
        ]);
    }
}
