<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        return view('user.payment.index');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'amount' => 'required|numeric|min:0.01',
                'depositSlip' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Handle the file upload
            if ($request->hasFile('depositSlip')) {
                $file = $request->file('depositSlip');
                $path = $file->store('public/deposit_slips');

                // Remove 'public/' from the path to store in the database
                $path = str_replace('public/', '', $path);
            }

            $payment            = new Payment();
            $payment->user_id   = auth()->user()->id;
            $payment->amount    = $request->input('amount');
            $payment->bank_slip = $path;

            $res = $payment->save();

            DB::commit();
            if($res){
                // Return a JSON response
                return response()->json([
                    'message' => 'Payment submitted successfully!',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }
}
