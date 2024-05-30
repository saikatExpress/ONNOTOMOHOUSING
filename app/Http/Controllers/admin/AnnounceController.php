<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Announce;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnnounceController extends Controller
{
    public function __construct()
    {
        if(!Auth::check()){
            return redirect()->route('logout.us');
        }
    }

    public function index()
    {
        $data['announces'] = Announce::with('creator')->get();

        return view('admin.announce.index')->with($data);
    }


    public function create()
    {
        return view('admin.announce.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'title' => ['required'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $title         = Str::title($request->input('title'));
            $description   = Str::title($request->input('description'), NULL);
            $announce_date = ($request->input('announce_date')) ?? Carbon::now();

            $announceObj = new Announce();

            $announceObj->title         = $title;
            $announceObj->description   = $description;
            $announceObj->announce_date = $announce_date;
            $announceObj->created_by    = Auth::id();

            $res = $announceObj->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Annouce created successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'title' => ['required'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $title         = Str::title($request->input('title'));
            $description   = Str::title($request->input('description'), NULL);
            $announce_date = ($request->input('announce_date')) ?? Carbon::now();

            $announceId = $request->input('announceId');
            $announce   = Announce::findOrFail($announceId);

            $announce->title         = $title;
            $announce->description   = $description;
            $announce->announce_date = $announce_date;
            $announce->updated_by    = Auth::id();
            $announce->updated_at    = Carbon::now();

            $res = $announce->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Annouce update successfully');
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

            $announce = Announce::findOrFail($id);

            if ($announce) {
                $res = $announce->delete();

                DB::commit();
                if($res){
                    return response()->json(['success' => true]);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'Announce not found.']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }
}
