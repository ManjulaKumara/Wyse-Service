<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\InvoiceHeader;
use DB;
use DateTime;


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
            $last_code_no=$max_code[0]->invoice_number;
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

            DB::commit();
            return redirect()->back()->with('success','Customer Receipt Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
