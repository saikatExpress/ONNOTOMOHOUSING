<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Announce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $totalCashDeposite = User::where('id', Auth::id())->sum('total_deposite_balance');
        $currentBalance    = User::where('id', Auth::id())->sum('current_balance');
        $announces         = Announce::where('status', '1')->latest()->limit(6)->get();
        $posts             = Post::with('user')->latest()->limit(20)->get();

        return view('user.home.index', compact('totalCashDeposite', 'announces', 'currentBalance', 'posts'));
    }

    public function userProfile()
    {
        $users = User::where('role', 'user')->latest()->take(5)->get();

        return view('user.profile.profile', compact('users'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $userId = $request->input('userId');
            $user = User::findOrFail($userId);

            // Validate the request
            $request->validate([
                'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name'         => 'required|string|max:255',
                'email'        => 'required|email|max:255|unique:users,email,' . $user->id,
                'mobile'       => 'required|string|max:15',
                'whatsapp'     => 'required|string|max:15',
                'address'      => 'nullable|string|max:500',
            ]);

            // Handle the image upload
            if ($request->hasFile('profileImage')) {
                // Delete the old image if exists
                if ($user->profile_image) {
                    Storage::delete($user->profile_image);
                }
                // Store the new image
                $path = $request->file('profileImage')->store('profile_images', 'public');
                // Update the user's profile image path
                $user->profile_image = $path;
            }

            $user->name     = $request->input('name');
            $user->email    = $request->input('email');
            $user->mobile   = $request->input('mobile');
            $user->whatsapp = $request->input('whatsapp');
            $user->address  = $request->input('address');

            // Save the updated user data
            $res = $user->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Profile updated successfully');
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }
}
