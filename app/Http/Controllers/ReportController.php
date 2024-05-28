<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        $data['users'] = User::where('role', 'user')->get();

        return view('admin.report.create')->with($data);
    }

    public function search(Request $request)
    {
        $query = Expense::query();
        return $query;

        if ($request->holder_id) {
            $query->where('holder_id', $request->holder_id);
        }

        if ($request->amount_type) {
            $query->where('amount_type', $request->amount_type);
        }

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        return DataTables::of($query)
            ->addColumn('holder_name', function ($row) {
                return $row->holder->name; // Assuming there's a relationship defined in your model
            })
            ->editColumn('date', function ($row) {
                return $row->created_at->format('d M Y, h:i A');
            })
            ->make(true);
    }
}
