<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\InvoiceHeader;
use App\Models\CustomerRecept;
use App\Models\CustomerReceptDetail;
use DB;
use DateTime;
use Illuminate\Support\Facades\Auth;


class CustomerReceiptController extends Controller
{
    public function create(){
        $customers=Customer::get();
        view()->share('customers',$customers);
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        $receipt_number=$this->code_create();
        view()->share('receipt_number',$receipt_number);
        return view('pages.customer-receipt.customer-receipts');
    }
    public function code_create(){
        $max_code=DB::select("select recept_no  from customer_recepts  ORDER BY RIGHT(recept_no , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->recept_no;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='CUST-R'.'-'.sprintf('%010d', intval($new_code) + 1);
        return $new_code;
    }

    public function get_pending_invoices($customer_id){
        $invoices=InvoiceHeader::where('customer',$customer_id)->where('balance','>',0)->get();
        return response()->json($invoices,200);
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $header_data=[
                'recept_no'=>$this->code_create(),
                'customer'=>$request->customer,
                'recept_amount'=>$request->total,
                'payment_type'=>$request->pay_method,
                'cashier'=>Auth::user()->id,
            ];
            $header=new CustomerRecept($header_data);
            $header->save();
            $customer=Customer::find($request->customer);
            $customer->current_balance=$customer->current_balance-$request->total;
            $customer->save();
            if(isset($request->details)){
                foreach($request->details as $element){
                    $detail_data=[
                        'recept_id'=>$header->id,
                        'invoice'=>$element['invoice'],
                        'balance_before'=>$element['balance'],
                        'pay_amount'=>$element['pay_amount'],
                        'balance_after'=>$element['balance']-$element['pay_amount'],
                    ];
                    $details=new CustomerReceptDetail($detail_data);
                    $details->save();
                }
            }
            if($request->pay_method=='cheque'){
                $cheque_data=[
                    'receipt_id'=>$header->id,
                    'customer'=>$header->customer,
                    'cheque_number'=>$request->cheque_number,
                    'bank_name'=>$request->bank_name,
                    'banked_date'=>$request->cheque_date,
                    'cheque_amount'=>$detail->pay_amount,
                    'is_returned'=>0,
                    'cashier'=>Auth::user()->id,
                ];
                $cheque=new CustomerCheque($cheque_data);
                $cheque->save();
                $cash_data=[
                    'transaction_type'=>'customer-cheque',
                    'reference_id'=>$cheque->id,
                    'debit_amount'=>0,
                    'credit_amount'=>$$request->total,
                ];
                $cash=new CashTransaction($cash_data);
                $cash->save();
            }else{
                $cash_data=[
                    'transaction_type'=>'supplier-voucher',
                    'reference_id'=>$header->id,
                    'debit_amount'=>0,
                    'credit_amount'=>$request->total,
                ];
                $cash=new CashTransaction($cash_data);
                $cash->save();
            }
            DB::commit();
            return redirect()->back()->with('success','Customer Receipt Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
