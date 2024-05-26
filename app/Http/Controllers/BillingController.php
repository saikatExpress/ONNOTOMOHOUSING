<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return view('user.billing.index');
    }

    public function billIndex()
    {
        $payments = Payment::with('user')->latest()->get();
        $shareHolders = User::where('role', 'user')->where('status', '1')->get();

        return view('admin.payment.index', compact('payments', 'shareHolders'));
    }
}
