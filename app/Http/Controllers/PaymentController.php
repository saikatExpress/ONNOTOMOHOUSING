<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, $id)
    {
        // Validate the form input
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'depositSlip' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $payment = Payment::find($id);

        if ($payment) {
            // Handle the file upload
            if ($request->hasFile('depositSlip')) {
                // Delete the old file
                if (Storage::disk('public')->exists($payment->bank_slip)) {
                    Storage::disk('public')->delete($payment->bank_slip);
                }

                $file               = $request->file('depositSlip');
                $filePath           = $file->store('bank_slips', 'public');
                $payment->bank_slip = $filePath;
            }

            $payment->amount = $request->input('amount');
            $payment->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment updated successfully',
                'payment' => $payment,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Payment not found',
        ]);
    }

    public function savePayment(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'amount'      => 'required|numeric|min:0.01',
                'depositSlip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle the file upload
            if ($request->hasFile('depositSlip')) {
                $file = $request->file('depositSlip');
                $filePath = $file->store('deposit_slips', 'public');
            }

            $payment             = new Payment();
            $payment->user_id    = $request->input('userId');
            $payment->amount     = $request->input('amount');
            $payment->bank_slip  = $filePath;
            $payment->is_approve = 1;
            $payment->approve_by = Auth::id();
            $payment->updated_at = Carbon::now();

            $res = $payment->save();
            DB::commit();
            if($res){
                return response()->json([
                    'success' => true,
                    'message' => 'Payment created successfully',
                    'payment' => $payment,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function show($id)
    {
        $payment = Payment::find($id);

        if ($payment) {
            return response()->json([
                'success' => true,
                'payment' => $payment,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Payment not found',
        ]);
    }

    public function giveApprovePayment($id)
    {
        $payment = Payment::with('user')->where('id', $id)->first();

        if($payment){
            if($payment->is_approve == 1){
                return response()->json(['message' => true]);
            }
            $res = $payment->update(['is_approve' => 1, 'approve_by' => Auth::id(), 'updated_at' => Carbon::now()]);

            if($res){
                return response()->json(['success' => true]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Payment not found',
        ]);
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);

        if ($payment) {
            if($payment->is_approve == 1){
                return response()->json(['message' => 'This payment already approved..!']);
            }

            // Optionally delete the associated bank slip image
            if ($payment->bank_slip) {
                Storage::delete('public/' . $payment->bank_slip);
            }

            $payment->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Payment not found.']);
        }
    }

}
