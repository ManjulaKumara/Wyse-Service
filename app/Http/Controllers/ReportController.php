<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceHeader;
use App\Models\CashTransaction;
use App\Models\CustomerRecept;
use App\Models\Expense;
use App\Models\SupplierVoucher;
use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\GrnHeader;
use App\Models\StockIssue;
use App\Models\ItemStock;
use App\Models\MaterialIssue;
use App\Models\SalesReturn;
use DateTime;
use DB;


class ReportController extends Controller
{
    public function index(){
        $items=Item::get();
        view()->share('items',$items);
        return view('pages.reports.report-main');
    }
    public function daily_summary(){
        $date=new DateTime();
        $date=$date->format('Y-m-d');
        $total_sales=InvoiceHeader::where('created_at','like',$date.'%')->sum('net_amount');
        $total_cash=CashTransaction::where('transaction_type','sales-cash')->where('created_at','like',$date.'%')->sum('credit_amount');
        $total_cheque=CashTransaction::where('transaction_type','sales-cheque')->where('created_at','like',$date.'%')->sum('credit_amount');
        $total_credit=CashTransaction::where('transaction_type','sales-credit')->where('created_at','like',$date.'%')->sum('credit_amount');
        $total_cash_receipts=CustomerRecept::where('payment_type','cash')->where('created_at','like',$date.'%')->sum('recept_amount');
        $total_cheque_receipts=CustomerRecept::where('payment_type','cash')->where('created_at','like',$date.'%')->sum('recept_amount');
        $total_returns=SalesReturn::where('created_at','like',$date.'%')->sum('return_amount');

        $total_expenses=Expense::where('expense_date','like',$date.'%')->sum('expense_amount');
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
            'total_returns'=>$total_returns,
        ];
        view()->share('date',$date);
        view()->share('data',$data);
        return view('pages.reports.daily-summary');
    }

    public function fill_data_summary(Request $request){
        $date=$request->summary_date;
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
        view()->share('date',$date);
        view()->share('data',$data);
        return view('pages.reports.daily-summary');
    }

    public function bincard(){
        view()->share('bin_data',null);
        return view('pages.reports.bincard');
    }

    public function fill_bincard(Request $request){
        $item=$request->item;
        $qih=ItemStock::where('item',$item)->sum('qty_in_hand');
        view()->share('qih',$qih);
        $item=Item::find($item);
        view()->share('item',$item);
        $transactions=ItemTransaction::where('item',$item->id)->get();
        $bincard_data=[];
        foreach($transactions as $transaction){
            $date=new DateTime($transaction->created_at);
            $date=$date->format('Y-m-d');
            $refrence="";
            if($transaction->transaction_type=="open stock"){
                $reference=$item->item_code;
            }elseif($transaction->transaction_type=="GRN"){
                $grn=GrnHeader::find($transaction->reference_id);
                $reference=$grn->grn_code;
            }elseif($transaction->transaction_type=="sales/stock-issue"){
                //need to get invoice id from stock issue number.
                $issue=StockIssue::find($transaction->reference_id);
                $invoice=InvoiceHeader::find($issue->invoice);
                $reference=($invoice)?$invoice->invoice_number:$issue->id;
            }elseif($transaction->transaction_type=="damage"){
                $reference=$transaction->reference_id;
            }elseif($transaction->transaction_type=="material-issue"){
                $issue=MaterialIssue::find($transaction->reference_id);
                $reference=$issue->issue_no;
            }
            $data=[
                'date'=>$date,
                'transaction_type'=>$transaction->transaction_type,
                'tran_status'=>$transaction->tran_status,
                'transfer_qty'=>$transaction->transfer_qty,
                'reference_id'=>$reference,
                'balance'=>$transaction->total_qih_after,
            ];
            array_push($bincard_data,(object)$data);
        }
        view()->share('bin_data',$bincard_data);
        return view('pages.reports.bincard');
    }

    public function sales_reports(){
        view()->share('sales_entry',null);
        return view('pages.reports.sales-report');
    }

    public function fill_sales_reports(Request $request){
        $from=$request->from_date;
        $to=$request->to_date;
        $invoices=CashTransaction::where('transaction_type','like','sales%')->where('created_at','<=',$to)->where('created_at','>=',$from)->distinct()->get('reference_id');
        $sales_entry=[];
        foreach($invoices as $element){
            $invoice=InvoiceHeader::find($element->reference_id);
            $cash_sale=CashTransaction::where('reference_id',$element->reference_id)->where('transaction_type','sales-cash')->where('created_at','<=',$to)->where('created_at','>=',$from)->sum('credit_amount');
            $cheque_sale=CashTransaction::where('reference_id',$element->reference_id)->where('transaction_type','sales-cheque')->where('created_at','<=',$to)->where('created_at','>=',$from)->sum('credit_amount');
            $credit_sale=CashTransaction::where('reference_id',$element->reference_id)->where('transaction_type','sales-credit')->where('created_at','<=',$to)->where('created_at','>=',$from)->sum('credit_amount');
            $date=new DateTime($invoice->created_at);
            $date=$date->format('Y-m-d');
            array_push($sales_entry,(object)['invoice_number'=>$invoice->invoice_number,'date'=>$date,'cash_sale'=>$cash_sale,'cheque_sale'=>$cheque_sale,'credit_sale'=>$credit_sale]);
        }
        view()->share('sales_entry',$sales_entry);
        view()->share('from_date',$from);
        view()->share('to_date',$to);
        return view('pages.reports.sales-report');
    }

    public function sales_summary(){
        view()->share('sales_entry',$sales_entry);
        return view('pages.reports.sales-summary');
    }

    public function fill_sales_summary(Request $request){
        $from=$request->from_date;
        $to=$request->to_date;
        $dates=CashTransaction::where('transaction_type','like','sales%')->where('created_at','<=',$to)->where('created_at','>=',$from)->distinct()->get('transaction_date');
        $sales_entry=[];
        foreach($dates as $element){
            $invoices=CashTransaction::where('transaction_type','like','sales%')->where('transaction_date',$element->transaction_date)->distinct()->get('reference_id');
            $invoice_details=[];
            $total_cash_sale=0;
            $total_cheque_sale=0;
            $total_credit_sale=0;
            $total=0;
            foreach($invoices as $inv){
                $cash_sale=CashTransaction::where('reference_id',$inv->reference_id)->where('transaction_type','sales-cash')->sum('credit_amount');
                $cheque_sale=CashTransaction::where('reference_id',$inv->reference_id)->where('transaction_type','sales-cheque')->sum('credit_amount');
                $credit_sale=CashTransaction::where('reference_id',$inv->reference_id)->where('transaction_type','sales-credit')->sum('credit_amount');
                $total_cash_sale=$total_cash_sale+$cash_sale;
                $total_cheque_sale=$total_cheque_sale+$cheque_sale;
                $total_credit_sale=$total_credit_sale+$credit_sale;
            }

            array_push($sales_entry,(object)['date'=>$element->transaction_date,'cash_sale'=>$total_cash_sale,'cheque_sale'=>$total_cheque_sale,'credit_sale'=>$total_credit_sale]);
        }
        view()->share('from_date',$from);
        view()->share('to_date',$to);
        view()->share('sales_entry',$sales_entry);
        return view('pages.reports.sales-summary');
    }

    public function price_list(){
        $stocks=ItemStock::distinct()->get('item');
        $price_list=[];
        foreach($stocks as $element){
            $item=Item::find($element->item);
            $price=ItemStock::where('item',$item->id)->orderBy('id','desc')->first();
            array_push($price_list,(object)['item_code'=>$item->item_code,'item_name'=>$item->item_name,'selling_price'=>$price->sales_price,'discount'=>$item->discount_rate]);
        }
        view()->share('price_list',$price_list);
        return view('pages.reports.price-list');
    }

    public function stock_report(){
        $items=Item::where('is_active',1)->get();
        $stock_list=[];
        foreach($items as $item){
            $item_qty=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            array_push($stock_list,(object)['item_code'=>$item->item_code,'item_name'=>$item->item_name,'stock'=>$item_qty]);
        }
        view()->share('stock_list',$stock_list);
        return view('pages.reports.stock-report');
    }

}
