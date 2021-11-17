<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\CashTransaction;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

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
            $expense->save();
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

    public function expense_index(){
        return view('pages.expenses.index');
    }

    public function expense_get_all(Request $request){
        $columns = [
            0 =>'expense_name',
            1 =>'expense_amount',
            2=> 'created_at',
            3=> 'cashier',
        ];
        $totalData = Expense::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $expenses = Expense::join('users','expenses.cashier','=','users.id')
                    ->select('expenses.*','users.name as name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $expenses =  Expense::join('users','expenses.cashier','=','users.id')
                        ->select('expenses.*','users.name as name')
                        ->where('expenses.expense_name','LIKE',"%{$search}%")
                        ->orWhere('expenses.expense_amount', 'LIKE',"%{$search}%")
                        ->orWhere('expenses.created_at', 'LIKE',"%{$search}%")
                        ->orWhere('users.name', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Expense::join('users','expenses.cashier','=','users.id')
                        ->select('expenses.*','users.name as name')
                        ->where('expenses.expense_name','LIKE',"%{$search}%")
                        ->orWhere('expenses.expense_amount', 'LIKE',"%{$search}%")
                        ->orWhere('expenses.created_at', 'LIKE',"%{$search}%")
                        ->orWhere('users.name', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($expenses) ) {
            foreach ($expenses as $item)
                {
                    $expense['expense_name'] = $item->expense_name;
                    $expense['expense_amount'] = $item->expense_amount;
                    $expense['created_at'] = $item->created_at->format('Y-m-d');
                    $expense['cashier'] = $item->name;
                    $data[] = $expense;

                }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
            );

        echo json_encode($json_data);
    }
}
