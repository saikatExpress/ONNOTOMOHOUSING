<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ExpenseLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::where('status', '1')->get();
        $data['expenses']   = Expense::with('categories', 'admin')->get();

        return view('admin.expense.index')->with($data);
    }


    public function create()
    {
        $data['categories'] = Category::where('status', '1')->get();
        $data['users']      = User::where('role', 'user')->get();

        return view('admin.expense.create')->with($data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'holder_id'   => ['required'],
                'cost_head'   => ['required'],
                'cost_amount' => ['required', 'integer'],
                'cost_date'   => ['required'],
                'remark'      => ['string'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $expenseObj = new Expense();

            $costHead   = $request->input('cost_head');
            $costAmount = (int) ($request->input('cost_amount')) ?? 0;
            $costDate   = $request->input('cost_date');
            $remark     = $request->input('remark');

            $expenseObj->cost_head   = $costHead;
            $expenseObj->cost_amount = $costAmount;
            $expenseObj->cost_date   = $costDate;
            $expenseObj->remark      = $remark;
            $expenseObj->created_by  = Auth::id();

            $res = $expenseObj->save();

            DB::commit();
            if($res){
                $holders = $request->input('holder_id');
                $result = $this->createExpenseLog($holders, $costHead, $expenseObj->id, $costDate,$costAmount,$remark);
                if($result == true){
                    foreach($holders as $holder){
                        $user = User::find($holder);
                        $intitalBalance = $user->current_balance;
                        $newBalance = (int) $intitalBalance - (int) $costAmount;
                        $user->update(['current_balance' => $newBalance]);
                    }
                    return redirect()->back()->with('message', 'Expense created successfully');
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }

    public function createExpenseLog($ids, $costHead,$lastId,$date,$amount,$remark)
    {
        foreach($ids as $id){
            $expenseLogObj = new ExpenseLog();

            $expenseLogObj->user_id      = $id;
            $expenseLogObj->cost_head    = $costHead;
            $expenseLogObj->expense_id   = $lastId;
            $expenseLogObj->expense_date = $date;
            $expenseLogObj->cost_amount  = $amount;
            $expenseLogObj->remark       = $remark;

            $expenseLogObj->save();
        }

        return true;
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'cost_head'   => ['required'],
                'cost_amount' => ['required', 'integer'],
                'cost_date'   => ['required'],
                'remark'      => ['string'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $expenseId = $request->input('expenseId');
            $expense   = Expense::findOrFail($expenseId);

            $costHead   = $request->input('cost_head');
            $costAmount = (int) ($request->input('cost_amount')) ?? 0;
            $costDate   = $request->input('cost_date');
            $remark     = $request->input('remark');

            $expense->cost_head   = $costHead;
            $expense->cost_amount = $costAmount;
            $expense->cost_date   = $costDate;
            $expense->remark      = $remark;
            $expense->updated_by  = Auth::id();
            $expense->updated_at  = Carbon::now();

            $res = $expense->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Expense update successfully');
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $expense = Expense::findOrFail($id);

            if ($expense) {
                $res = $expense->delete();

                DB::commit();
                if($res){
                    return response()->json(['success' => true]);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'Expense not found.']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }
}
