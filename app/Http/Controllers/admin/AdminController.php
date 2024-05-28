<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function dueIndex()
    {
        $data['users'] = User::where('role', 'user')->where('current_balance' ,'<', 0)->get();

        return view('admin.user.due')->with($data);
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
