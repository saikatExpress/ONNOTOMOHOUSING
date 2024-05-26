<?php

namespace App\View\Components;

use Closure;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SideBar extends Component
{
    public $totalPayments,$totalCatgeories;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->totalPayments = Payment::where('is_approve', 0)->count();
        $this->totalCatgeories = Category::count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side-bar');
    }
}
