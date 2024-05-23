<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signUp()
    {
        return view('auth.signup');
    }

    public function authCheck(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'email'    => ['required'],
                'password' => ['required']
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $email    = $request->input('email');
            $password = $request->input('password');

            $user = User::where('email', $email)->first();

            if($user){
                if($user->status == '0'){
                    return redirect()->back()->with('error', 'This account is Deactive.If you want to your account active,please contact with admin...!');
                }

                if($user->is_block == 1){
                    return redirect()->back()->with('error', 'This account is bloked..!');
                }
            }

            $credentials = $request->only('email', 'password');

            if(Auth::attempt($credentials)) {
                $authUser = Auth::user();
                $request->session()->regenerate();

                $request->session()->put('user_id', $authUser->id);

                if($user->role === 'user') {
                    // $user->update(['otp' => null, 'user_agent' => $request->header('User-Agent'), 'last_login_at' => Carbon::now()]);
                    return redirect()->route('user.dashboard');
                } elseif($user->role === 'admin') {
                    // $user->update(['otp' => null, 'user_agent' => $request->header('User-Agent'), 'last_login_at' => Carbon::now()]);
                    return redirect()->route('admin.dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Email or password does not match..!');
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
