<?php

namespace App\View\Components;

use App\Models\Payment;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideBar extends Component
{
    public $totalPayments;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->totalPayments = Payment::where('is_approve', 0)->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side-bar');
    }
}
