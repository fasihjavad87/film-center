<?php

namespace App\Livewire\Panel\PurchaseHistory;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseHistoryList extends Component
{
    use WithPagination;


    #[Layout('panel.master')]
    public function render(): View
    {
        $currentUserId = Auth::id();
        $payments = Payment::query()
            // فقط پلن‌های فعال را نمایش می‌دهیم
            ->where('user_id', $currentUserId)
            // کدهای تخفیف را eager load می‌کنیم
            ->with('plan')
            ->latest()
            ->paginate(10);
        return view('livewire.panel.purchase-history.purchase-history-list' , ['payments' => $payments]);
    }
}
