<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        $data['schedules'] = Schedule::with('holders')->latest()->get();

        return view('admin.schedule.index')->with($data);
    }

    public function create()
    {
        $data['users'] = User::where('role', 'user')->get();

        return view('admin.schedule.create')->with($data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'holder_id'     => ['required'],
                'task_name'     => ['required'],
                'schedule_date' => ['required'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $holderId     = $request->input('holder_id');
            $taskName     = Str::title($request->input('task_name'));
            $scheduleDate = $request->input('schedule_date');
            $remark       = Str::title($request->input('remark'));

            $scheduleObj = new Schedule();

            $scheduleObj->holder_id     = $holderId;
            $scheduleObj->task_name     = $taskName;
            $scheduleObj->schedule_date = $scheduleDate;
            $scheduleObj->remark        = $remark;
            $scheduleObj->created_by    = Auth::id();

            $res = $scheduleObj->save();

            DB::commit();

            if($res){
                return redirect()->back()->with('message', 'Task assigned successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $schedule = Schedule::findOrFail($id);

            if ($schedule) {
                $res = $schedule->delete();

                DB::commit();
                if($res){
                    return response()->json(['success' => true]);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'Schedule not found.']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }
}
