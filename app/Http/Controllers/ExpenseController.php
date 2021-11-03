<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\CashTransaction;
use DB;
use DateTime;

class ExpenseController extends Controller
{
    public function create(){
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        return view('pages.expenses.expenses');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $expense_data=[
                'expense_name'=>$request->expense_name,
                'expense_amount'=>$request->expense_amount,
                'cashier'=>Auth::user()->id,
            ];
            $expense=new Expense($expense_data);
            $expense_data->save();
            $transaction_data=[
                'transaction_type'=>'Expenses',
                'reference_id'=>$expense->id,
                'debit_amount'=>$request->expense_amount,
                'credit_amount'=>0.00,
            ];
            $transaction=new CashTransaction($transaction_data);
            $transaction->save();
            DB::commit();
            return redirect()->back()->with('success','Item Relationship Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
