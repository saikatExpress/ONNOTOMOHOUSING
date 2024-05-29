<?php

namespace App\View\Components;

use Closure;
use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class TaskSchedule extends Component
{
    public $allTask;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->allTask = Schedule::with('holders:id,name')->whereDate('schedule_date', Carbon::now())->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.task-schedule');
    }
}
