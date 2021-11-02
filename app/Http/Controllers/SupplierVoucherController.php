<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierVoucher;
use App\Models\GrnHeader;
use App\Models\SupplierVoucherDetail;
use App\Models\SupplierCheque;
use DateTime;
use DB;

class SupplierVoucherController extends Controller
{
    public function create(){
        $suppliers=Supplier::get();
        view()->share('suppliers',$suppliers);
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        $voucher_number=$this->code_Create();
        view()->share('voucher_number',$voucher_number);
        return view('pages.supplier-voucher.supplier-voucher');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $header_data=[
                'voucher_number'=>$this->code_Create(),
                'cashier'=>Auth::user()->id,
                'supplier'=>$request->supplier,
                'total_amount'=>$request->total,
                'pay_type'=>$request->pay_method,
            ];
            $header=new SupplierVoucher($header_data);
            $header->save();
            if(isset($request->details)){
                foreach($request->details as $element){
                    $detail_data=[
                        'voucher_id'=>$header->id,
                        'grn'=>$element['grn'],
                        'balance_before'=>$element['balance'],
                        'pay_amount'=>$element['pay_amount'],
                        'balance_after'=>$element['balance']-$element['pay_amount'],
                    ];
                    $details=new SupplierVoucherDetail($detail_data);
                    $details->save();
                }
            }
            if($request->pay_method=='cheque'){
                $cheque_data=[
                    'supplier'=>$request->supplier,
                    'cheque_no'=>$request->cheque_number,
                    'account'=>$request->account_no,
                    'bank'=>$request->bank_name,
                    'cheque_date'=>$request->cheque_date,
                    'amount'=>$request->total,
                    'voucher_id'=>$header->id,
                ];
                $cheque=new SupplierCheque($cheque_data);
                $cheque->save();
                $cash_data=[
                    'transaction_type'=>'supplier-cheque',
                    'reference_id'=>$header->id,
                    'debit_amount'=>$request->total,
                    'credit_amount'=>0,
                ];
                $cash=new CashTransaction($cash_data);
                $cash->save();
            }else{
                $cash_data=[
                    'transaction_type'=>'supplier-voucher',
                    'reference_id'=>$header->id,
                    'debit_amount'=>$request->total,
                    'credit_amount'=>0,
                ];
                $cash=new CashTransaction($cash_data);
                $cash->save();
            }
            DB::commit();
            return redirect()->back()->with('success','Supplier Voucher Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }

    public function get_pending_grns($supplier_id){
        $vouchers=GrnHeader::where('supplier',$supplier_id)->where('balance','>',0)->get();
        return response()->json($vouchers,200);
    }

    public function code_Create() {
        $max_code=DB::select("select voucher_number  from supplier_vouchers  ORDER BY RIGHT(voucher_number , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->invoice_number;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='SUP-V'.'-'.sprintf('%010d', intval($new_code) + 1);
        return $new_code;
    }
}
