<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceHeader;
use App\Models\CashTransaction;
use App\Models\CustomerRecept;
use App\Models\Expense;
use App\Models\SupplierVoucher;
use DateTime;


class ReportController extends Controller
{
    public function daily_summary(){
        view()->share('data',null);
        return view('pages.reports.daily-summary');
    }

    public function fill_data_summary(Request $request){
        $date=$request->date;
        $date=new DateTime($date);
        $date=$date->format('Y-m-d');
        $total_sales=InvoiceHeader::where('created_at','like',$date.'%')->sum('net_amount');
        $total_cash=CashTransaction::where('transaction_type','sales-cash')->where('created_at','like',$date.'%')->sum('credit_amount');
        $total_cheque=CashTransaction::where('transaction_type','sales-cheque')->where('created_at','like',$date.'%')->sum('credit_amount');
        $total_credit=CashTransaction::where('transaction_type','sales-credit')->where('created_at','like',$date.'%')->sum('credit_amount');
        $total_cash_receipts=CustomerRecept::where('payment_type','cash')->where('created_at','like',$date.'%')->sum('recept_amount');
        $total_cheque_receipts=CustomerRecept::where('payment_type','cash')->where('created_at','like',$date.'%')->sum('recept_amount');

        $total_expenses=Expense::where('created_at','like',$date.'%')->sum('expense_amount');
        $total_voucher_cash=SupplierVoucher::where('pay_type','cash')->where('created_at','like',$date.'%')->sum('total_amount');
        $total_voucher_cheque=SupplierVoucher::where('pay_type','cheque')->where('created_at','like',$date.'%')->sum('total_amount');
        $data=[
            'total_sales'=>$total_sales,
            'total_cash'=>$total_cash,
            'total_cheque'=>$total_cheque,
            'total_credit'=>$total_credit,
            'total_cash_receipts'=>$total_cash_receipts,
            'total_cheque_receipts'=>$total_cheque_receipts,
            'total_expenses'=>$total_expenses,
            'total_voucher_cash'=>$total_voucher_cash,
            'total_voucher_cheque'=>$total_voucher_cheque,
        ];
        view()->share('data',$data);
        return view('pages.reports.daily-summary');
    }

    public function bincard(){
        return view('pages.reports.bincard');
    }
}
