<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        if(!Auth::check()){
            return redirect()->route('logout.us');
        }
    }

    public function index()
    {
        $data['users'] = User::where('role', 'user')->get();

        return view('admin.user.index')->with($data);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail(Auth::id());

            $request->validate([
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
                'mobile'        => 'required|string|max:15',
                'whatsapp'      => 'required|string|max:15',
                'address'       => 'nullable|string|max:500',
            ]);

            if ($request->hasFile('profile_image')) {
                // Delete the old image if exists
                if ($user->profile_image) {
                    Storage::delete($user->profile_image);
                }
                // Store the new image
                $path = $request->file('profile_image')->store('profile_images', 'public');
                // Update the user's profile image path
                $user->profile_image = $path;
            }

            $user->name     = Str::title($request->input('name'));
            $user->email    = $request->input('email');
            $user->mobile   = $request->input('mobile');
            $user->whatsapp = $request->input('whatsapp');
            $user->address  = $request->input('address');

            // Save the updated user data
            $res = $user->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Profile Update successfully');
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
                'con_password' => 'required|same:new_password',
            ]);

            $user = User::find(Auth::id());

            // Check if the old password matches
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['error' => 'Old password does not match'], 400);
            }

            $user->password = Hash::make($request->new_password);
            $res = $user->save();

            DB::commit();
            if($res){
                return response()->json(['success' => 'Password updated successfully']);
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function checkPassword($input)
    {
        $user = User::findOrFail(Auth::id());

        if (Hash::check($input, $user->password)) {
            // Passwords match
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => false]);
        }
    }

    public function userpassUpdate(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'password' => ['required']
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $userId   = $request->input('userId');
            $password = $request->input('password');

            $user = User::findOrFail($userId);

            if($user){
                $user->password = Hash::make($password);
                $res = $user->save();

                DB::commit();
                if($res){
                    return response()->json(['success' => true]);
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return back();
        }
    }

    public function userUpdate(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name'     => ['required'],
                'email'    => ['required', 'email'],
                'mobile'   => ['required', 'max:15'],
                'whatsapp' => ['required', 'max:15'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $userId   = $request->input('userId');
            $name   = $request->input('name');
            $email   = $request->input('email');
            $mobile   = $request->input('mobile');
            $whatsapp   = $request->input('whatsapp');
            $status   = $request->input('status');

            $user = User::findOrFail($userId);

            if($user){
                $user->name     = $name;
                $user->email    = $email;
                $user->mobile   = $mobile;
                $user->whatsapp = $whatsapp;
                $user->status   = $status;

                $res = $user->save();

                DB::commit();
                if($res){
                    return redirect()->back()->with('message', 'User update successfully');
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return back();
        }
    }

    public function dueIndex()
    {
        $data['users'] = User::where('role', 'user')->where('current_balance' ,'<', 0)->get();

        return view('admin.user.due')->with($data);
    }

    public function profile()
    {
        return view('admin.profile.create');
    }

    public function adminDashBoard()
    {
        $data['totalDeposite'] = User::where('role', 'user')->sum('total_deposite_balance');
        $data['totalShareHolder'] = User::where('role', 'user')->count();
        $data['debitbalance'] = Expense::sum('cost_amount');
        $data['activeTotalShareHolder'] = User::where('role', 'user')->where('status', '1')->count();

        return view('admin.home.index')->with($data);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'profile_image'    => ['required', 'image', 'max:2048'],
                'name'             => ['required'],
                'mobile'           => ['required'],
                'email'            => ['required', 'unique:users'],
                'deposite_balance' => ['required', 'integer'],
                'password'         => ['required', 'min:6'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $userObj = new User();

            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $path = $file->store('profile_images', 'public');
            }

            $userObj->profile_image          = $path;
            $userObj->name                   = Str::title($request->input('name'));
            $userObj->mobile                 = $request->input('mobile');
            $userObj->whatsapp               = $request->input('mobile');
            $userObj->email                  = $request->input('email');
            $userObj->address                = $request->input('address');
            $userObj->country                = $request->input('country');
            $userObj->city                   = $request->input('city');
            $userObj->total_deposite_balance = (int) $request->input('deposite_balance');
            $userObj->current_balance        = (int) $request->input('deposite_balance');
            $userObj->password               = Hash::make($request->input('password'));
            $userObj->role                   = 'user';
            $userObj->created_by             = Auth::id();

            $res = $userObj->save();

            DB::commit();
            if($res){
                return redirect()->route('user.list')->with('message', 'User create successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }
}
