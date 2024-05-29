<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\ExpenseLog;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class ReportController extends Controller
{
    public function create()
    {
        $data['users'] = User::where('role', 'user')->get();

        return view('admin.report.create')->with($data);
    }

    public function search(Request $request)
    {
        $holderId   = $request->input('holder_id');
        $amountType = $request->input('amount_type');
        $fromDate   = $request->input('from_date');
        $toDate     = $request->input('to_date');

        if($holderId == 0){
            if($amountType === 'credit'){
                $payments = Payment::query()
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->get();

                // Return the view with payment results
                return view('admin.report.credit', ['payments' => $payments]);
            }
            if($amountType === 'debit'){
                $expenses = ExpenseLog::query()
                ->whereBetween('created_at', [$fromDate, $toDate])
                    ->get();

                // Return the view with expense results
                return view('admin.report.allDebit', ['expenses' => $expenses]);
            }
        }

        // Perform search based on amount type
        if ($amountType === 'credit') {
            // Search in payments table
            $payments = Payment::query()
                ->where('user_id', $holderId)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->get();

            // Return the view with payment results
            return view('admin.report.search', ['payments' => $payments]);
        } elseif ($amountType === 'debit') {
            $expenses = ExpenseLog::query()
                ->where('user_id', $holderId)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->get();

            // Return the view with expense results
            return view('admin.report.debit', ['expenses' => $expenses]);
        } else {
            // Handle invalid amount type
            return response()->json(['error' => 'Invalid amount type']);
        }
    }

    public function generatePdf(Request $request)
    {
        // Retrieve data or perform any necessary logic
        $data = [
            'name' => 'Saikat Talukder',
            'email' => 'saikat@gmail.com',
        ];
        // Generate PDF using Snappy
        $pdf = PDF::loadView('admin.pdf.invoice', $data);

        // Set the content type to PDF
        return $pdf->download('payment_results.pdf');
    }
}
