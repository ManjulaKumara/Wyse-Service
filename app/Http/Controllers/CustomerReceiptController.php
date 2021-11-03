<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerRecept;
use App\Models\InvoiceHeader;
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

            DB::commit();
            return redirect()->back()->with('success','Customer Receipt Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }

    public function customer_receipt_index(){
        return view('pages.customer-receipt.index');
    }

    public function customer_receipt_get_all(Request $request){
        $columns = [
            0 =>'recept_no',
            1 =>'customer',
            2=> 'recept_amount',
            3=> 'payment_type',
        ];
        $totalData = CustomerRecept::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $receipts = CustomerRecept::join('customers','customer_recepts.customer','=','customers.id')
                    ->select('customer_recepts.*','customers.customer_name as customer_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $receipts =  CustomerRecept::join('customers','customer_recepts.customer','=','customers.id')
                        ->select('customer_recepts.*','customers.customer_name as customer_name')
                        ->where('customer_recepts.recept_no','LIKE',"%{$search}%")
                        ->orWhere('customers.customer_name', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = CustomerRecept::join('customers','customer_recepts.customer','=','customers.id')
                        ->select('customer_recepts.*','customers.customer_name as customer_name')
                        ->where('customer_recepts.recept_no','LIKE',"%{$search}%")
                        ->orWhere('customers.customer_name', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($receipts) ) {
            foreach ($receipts as $item)
                {
                    $receipt['recept_no'] = $item->recept_no;
                    $receipt['customer'] = $item->customer_name;
                    $receipt['recept_amount'] = $item->recept_amount;
                    $receipt['payment_type'] = $item->payment_type;
                    $receipt['action'] = '<div class="btn-group">
                    <a href="#'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    </div>';
                    $data[] = $receipt;

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
