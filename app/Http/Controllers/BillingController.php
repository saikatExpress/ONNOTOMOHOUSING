<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\ExpenseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index()
    {
        $data['billings']          = ExpenseLog::with('categories', 'expenses')->where('user_id', Auth::id())->get();
        $data['totalCashDeposite'] = User::where('id', Auth::id())->sum('total_deposite_balance');
        $data['currentBalance']    = User::where('id', Auth::id())->sum('current_balance');
        $data['payments']          = Payment::where('user_id', Auth::id())->get();

        return view('user.billing.index')->with($data);
    }

    public function billIndex()
    {
        $payments     = Payment::with('user')->latest()->get();
        $shareHolders = User::where('role', 'user')->where('status', '1')->get();

        return view('admin.payment.index', compact('payments', 'shareHolders'));
    }
}
