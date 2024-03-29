<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemCategorie;
use App\Models\ServiceMaster;
use App\Models\StockIssue;
use App\Models\InvoiceHeader;
use App\Models\InvoiceItem;
use App\Models\InvoiceService;
use App\Models\InvoiceMaterial;
use App\Models\ItemTransaction;
use App\Models\CashTransaction;
use App\Models\CustomerRecept;
use App\Models\CustomerReceptDetail;
use App\Models\CustomerCheque;
use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function searchItem(Request $request){
        $search=$request->search;
        $items=Item::where('item_code','LIKE',"%{$search}%")->orWhere('barcode', 'LIKE',"%{$search}%")->orWhere('item_name', 'LIKE',"%{$search}%")->get();
        $item_list=[];
        foreach($items as $item){
            $item_qtys=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            if($item_qtys>0){
                $category=ItemCategorie::find($item->category);
                $sales_price=ItemStock::where('item',$item->id)->orderBy('id','desc')->first();
                $data=[
                    'id'=>$item->id,
                    'name'=>$item->item_name,
                    'category'=>$category->category_name,
                    'barcode'=>$item->barcode,
                    'item_code'=>$item->item_code,
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        return response()->json($item_list);
    }

    public function searchService(Request $request){
        $search=$request->search;
        $services=ServiceMaster::where('service_name','LIKE',"%{$search}%")->get();
        $item_list=[];
        foreach($services as $service){
            $data=[
                'id'=>$service->id,
                'name'=>$service->service_name,
                'stock_no'=>0,
                'category'=>'Service',
                'barcode'=>$service->id,
                'item_code'=>$service->id,
                'unit_price'=>$service->service_rate,
                'discount'=>$service->discount_rate,
                'qih'=>1,
                'type'=>'service',
            ];
            array_push($item_list,(object)$data);
        }
        return response()->json($item_list,200);
    }

    public function searchItemsnServices(Request $request){
        $items=Item::where('item_code','LIKE',"%{$search}%")->orWhere('barcode', 'LIKE',"%{$search}%")->orWhere('item_name', 'LIKE',"%{$search}%")->get();
        $item_list=[];
        foreach($items as $item){
            $item_qtys=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            if($item_qtys>0){
                $category=ItemCategorie::find($item->category);
                $sales_price=ItemStock::where('item',$item->id)->where('qty_in_hand','>',0)->orderBy('id')->first();
                $data=[
                    'id'=>$item->id,
                    'name'=>$item->item_code.' || '.$item->item_name,
                    'stock_no'=>$sales_price->id,
                    'category'=>$category->category_name,
                    'barcode'=>$item->barcode,
                    'item_code'=>$item->item_code,
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        $services=ServiceMaster::where('service_name','LIKE',"%{$search}%")->get();
        foreach($services as $service){
            $data=[
                'id'=>$service->id,
                'name'=>$service->service_name,
                'stock_no'=>0,
                'category'=>'Service',
                'barcode'=>$service->id,
                'item_code'=>$service->id,
                'unit_price'=>$service->service_rate,
                'discount'=>$service->discount_rate,
                'qih'=>1,
                'type'=>'service',
            ];
            array_push($item_list,(object)$data);
        }
        return response()->json($item_list,200);
    }

    public function create(){
        $customers=Customer::get();
        view()->share('customers',$customers);
        $invoice_number=$this->code_Create();
        view()->share('invoice_number',$invoice_number);
        $items=Item::where('is_active',1)->get();
        $item_list=[];
        foreach($items as $item){
            $item_qtys=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            if($item_qtys>0){
                $category=ItemCategorie::find($item->category);
                $sales_price=ItemStock::where('item',$item->id)->orderBy('id','desc')->first();
                $data=[
                    'id'=>$item->id,
                    'name'=>$item->item_name,
                    'category'=>$category->category_name,
                    'barcode'=>$item->barcode,
                    'item_code'=>$item->item_code,
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        $materials=Item::where('is_active',1)->where('item_type','Material')->get();
        foreach($materials as $material){
            $data=[
                'id'=>$material->id,
                'name'=>$material->item_name,
                'category'=>$material->category_name,
                'barcode'=>$material->barcode,
                'item_code'=>$material->item_code,
                'unit_price'=>0,
                'discount'=>0,
                'qih'=>null,
                'type'=>'material',
            ];
            array_push($item_list,(object)$data);
        }
        $services=ServiceMaster::get();
        foreach($services as $service){
            $data=[
                'id'=>$service->id,
                'name'=>$service->service_name,
                'category'=>'Service',
                'barcode'=>$service->id,
                'item_code'=>$service->id,
                'unit_price'=>$service->service_rate,
                'discount'=>$service->discount_rate,
                'qih'=>1,
                'type'=>'service',
            ];
            array_push($item_list,(object)$data);
        }
        view()->share('item_list',$item_list);
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        return view('pages.sales.sales');

    }

    public function getItemsAndServices(){
        $items=Item::where('is_active',1)->get();
        $item_list=[];
        foreach($items as $item){
            $item_qtys=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            if($item_qtys>0){
                $category=ItemCategorie::find($item->category);
                $sales_price=ItemStock::where('item',$item->id)->where('qty_in_hand','>',0)->orderBy('id')->first();
                $data=[
                    'id'=>$item->id,
                    'name'=>$item->item_name,
                    'stock_no'=>$sales_price->id,
                    'category'=>$category->category_name,
                    'barcode'=>$item->barcode,
                    'item_code'=>$item->item_code,
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        $materials=Item::where('is_active',1)->where('item_type','Material')->get();
        foreach($materials as $material){
            $data=[
                'id'=>$material->id,
                'name'=>$material->item_name,
                'category'=>$material->category_name,
                'barcode'=>$material->barcode,
                'item_code'=>$material->item_code,
                'unit_price'=>0,
                'discount'=>0,
                'qih'=>null,
                'type'=>'material',
            ];
            array_push($item_list,(object)$data);
        }
        $services=ServiceMaster::get();
        foreach($services as $service){
            $data=[
                'id'=>$service->id,
                'name'=>$service->service_name,
                'stock_no'=>0,
                'category'=>'Service',
                'barcode'=>$service->id,
                'item_code'=>$service->id,
                'unit_price'=>$service->service_rate,
                'discount'=>$service->discount_rate,
                'qih'=>1,
                'type'=>'service',
            ];
            array_push($item_list,(object)$data);
        }
        return response()->json($item_list,200);
    }

    public function getItems(){
        $items=Item::where('is_active',1)->get();
        $item_list=[];
        foreach($items as $item){
            $item_qtys=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            if($item_qtys>0){
                $category=ItemCategorie::find($item->category);
                $sales_price=ItemStock::where('item',$item->id)->where('qty_in_hand','>',0)->orderBy('id')->first();
                $data=[
                    'id'=>$item->id,
                    'name'=>$item->item_name,
                    'stock_no'=>$sales_price->id,
                    'category'=>$category->category_name,
                    'barcode'=>$item->barcode,
                    'item_code'=>$item->item_code,
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        $materials=Item::where('is_active',1)->where('item_type','Material')->get();
        foreach($materials as $material){
            $data=[
                'id'=>$material->id,
                'name'=>$material->item_name,
                'category'=>$material->category_name,
                'barcode'=>$material->barcode,
                'item_code'=>$material->item_code,
                'unit_price'=>0,
                'discount'=>0,
                'qih'=>null,
                'type'=>'material',
            ];
            array_push($item_list,(object)$data);
        }
        return response()->json($item_list,200);
    }

    public function getServices(){
        $services=ServiceMaster::get();
        $item_list=[];
        foreach($services as $service){
            $data=[
                'id'=>$service->id,
                'name'=>$service->service_name,
                'stock_no'=>0,
                'category'=>'Service',
                'barcode'=>$service->id,
                'item_code'=>$service->id,
                'unit_price'=>$service->service_rate,
                'discount'=>$service->discount_rate,
                'qih'=>1,
                'type'=>'service',
            ];
            array_push($item_list,(object)$data);
        }
        return response()->json($item_list,200);
    }

    public function getStockIssuesForVehicle($vehicle_no){
        $issued_items=StockIssue::where('vehicle_number',$vehicle_no)->where('is_invoiced',0)->get();
        $item_list=[];
        foreach($issued_items as $issued){
            $item=Item::find($issued->item);
            $item_Stock=ItemStock::find($issued->stock_no);
            $data=[
                'id'=>$item->id,
                'stock_no'=>$item_Stock->id,
                'code'=>$item->item_code,
                'barcode'=>$item->barcode,
                'name'=>$item->item_name,
                'quantity'=>$issued->qty,
                'unit_price'=>$item_Stock->sales_price,
                'discount'=>$item->discount_rate*$item_Stock->sales_price,
                'type'=>'item',
            ];
            array_push($item_list,(object)$data);
        }
        return response()->json($item_list,200);
    }

    public function code_Create() {
        $max_code=DB::select("select invoice_number  from invoice_header  ORDER BY RIGHT(invoice_number , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->invoice_number;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='INV'.'-'.sprintf('%010d', intval($new_code) + 1);
        return $new_code;
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $paid_amount=($request->pay_amount>$request->final_total)?$request->final_total:$request->pay_amount;
            if($request->pay_method=='cheque'){
                $paid_amount=$request->pay_amount;
            }
            $header_data=[
                'invoice_number'=>$this->code_Create(),
                'vehicle_number'=>$request->vehicle_no,
                'vehicle_type'=>$request->vehicle_type,
                'customer'=>$request->customer,
                'invoice_type'=>$request->inv_type,
                'cashier'=>Auth::user()->id,
                'remarks'=>$request->notes,
                'total_amount'=>$request->total,
                'discount_amount'=>$request->bill_discount,
                'net_amount'=>$request->final_total,
                'paid_amount'=>$paid_amount,
                'payment_type'=>$request->pay_method,
                'return_amount'=>0.00,
                'balance'=>$request->final_total-$paid_amount,
                'is_cancel'=>0,
            ];
            $header=new InvoiceHeader($header_data);
            $header->save();
            $returned_items=[];
            $return_amount=0;
            if(isset($request->details)){
                foreach($request->details as $element){
                    if($element['item_type']=='service'){
                        $service_data=[
                            'invoice'=>$header->id,
                            'service'=>$element['item'],
                            'qty'=>$element['qty'],
                            'unit_price'=>$element['unit_price'],
                            'discount'=>$element['discount'],
                            'amount'=>$element['amount'],
                            'billing_type'=>$element['is_return'],
                        ];
                        $service_record=new InvoiceService($service_data);
                        $service_record->save();
                        if($element['is_return']=='yes'){
                            $return_data=[
                                'item'=>$element['item'],
                                'qty'=>$element['qty'],
                                'unit_price'=>$element['unit_price'],
                                'amount'=>$element['amount'],
                                'stock_no'=>$element['stock_no'],
                            ];
                            array_push($returned_items,$return_data);
                            $return_amount=$return_amount+$element['amount'];
                        }

                    }
                    if($element['item_type']=='material'){
                        $material_data=[
                            'invoice'=>$header->id,
                            'item'=>$element['item'],
                            'qty'=>$element['qty'],
                            'unit_price'=>$element['unit_price'],
                            'amount'=>$element['amount'],
                            'billing_type'=>$element['is_return'],
                        ];
                        $material_record=new InvoiceMaterial($material_data);
                        $material_record->save();
                        if($element['is_return']=='yes'){
                            $return_data=[
                                'item'=>$element['item'],
                                'qty'=>$element['qty'],
                                'unit_price'=>$element['unit_price'],
                                'amount'=>$element['amount'],
                                'stock_no'=>$element['stock_no'],
                            ];
                            array_push($returned_items,$return_data);
                            $return_amount=$return_amount+$element['amount'];
                        }

                    }
                    if($element['item_type']=='item'){
                        $stock_issue=StockIssue::where('vehicle_number',$request->vehicle_no)->where('item',$element['item'])->where('is_invoiced',0)->first();
                        if($stock_issue){
                            $stock_issue->is_invoiced=1;
                            $stock_issue->invoice=$header->id;
                            $stock_issue->save();
                            $item_data=[
                                'invoice'=>$header->id,
                                'item'=>$element['item'],
                                'qty'=>$element['qty'],
                                'unit_price'=>$element['unit_price'],
                                'discount'=>$element['discount'],
                                'amount'=>$element['amount'],
                                'stock_no'=>$stock_issue->id,
                                'billing_type'=>$element['is_return']
                            ];
                            $item_record=new InvoiceItem($item_data);
                            $item_record->save();
                        }else{
                            $item_stock=null;
                            $item_stock=ItemStock::where('item',$element['item'])->where('qty_in_hand','>=',$element['qty'])->orderBy('id')->first();
                            if($item_stock){
                                if($element['is_return']=='yes'){
                                    $return_data=[
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'unit_price'=>$element['unit_price'],
                                        'amount'=>$element['amount'],
                                        'stock_no'=>$element['stock_no'],
                                    ];
                                    array_push($returned_items,$return_data);
                                    $return_amount=$return_amount+$element['amount'];
                                    $item_data=[
                                        'invoice'=>$header->id,
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'unit_price'=>$element['unit_price'],
                                        'discount'=>$element['discount'],
                                        'amount'=>$element['amount'],
                                        'stock_no'=>$element['stock_no'],
                                        'billing_type'=>$element['is_return']
                                    ];
                                    $item_record=new InvoiceItem($item_data);
                                    $item_record->save();
                                }elseif($element['is_return']=='display'){
                                    $item_data=[
                                        'invoice'=>$header->id,
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'unit_price'=>$element['unit_price'],
                                        'discount'=>$element['discount'],
                                        'amount'=>$element['amount'],
                                        'stock_no'=>$element['stock_no'],
                                        'billing_type'=>$element['is_return']
                                    ];
                                    $item_record=new InvoiceItem($item_data);
                                    $item_record->save();
                                }else{
                                    $issue_data=[
                                        'vehicle_number'=>$request->vehicle_no,
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'stock_no'=>$item_stock->id,
                                        'is_invoiced'=>1,
                                        'invoice'=>$header->id,
                                    ];
                                    $issue=new StockIssue($issue_data);
                                    $issue->save();
                                    $item_stock->qty_in_hand=$item_stock->qty_in_hand-$element['qty'];
                                    $item_stock->save();
                                    $item_qtys=ItemStock::where('item',$element['item'])->sum('qty_in_hand');
                                    $transaction_data=[
                                        'stock_id'=>$item_stock->id,
                                        'item'=>$element['item'],
                                        'transaction_type'=>'sales/stock-issue',
                                        'tran_status'=>'out',
                                        'qih_before'=>$item_stock->qty_in_hand+$element['qty'],
                                        'qih_after'=>$item_stock->qty_in_hand,
                                        'transfer_qty'=>$element['qty'],
                                        'reference_id'=>$issue->id,
                                        'total_qih_before'=>$item_qtys+$element['qty'],
                                        'total_qih_after'=>$item_qtys,
                                    ];
                                    $transaction=new ItemTransaction($transaction_data);
                                    $transaction->save();
                                    $item_data=[
                                        'invoice'=>$header->id,
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'unit_price'=>$element['unit_price'],
                                        'discount'=>$element['discount'],
                                        'amount'=>$element['amount'],
                                        'stock_no'=>$item_stock->id,
                                        'billing_type'=>$element['is_return']
                                    ];
                                    $item_record=new InvoiceItem($item_data);
                                    $item_record->save();
                                }
                            }else{
                                if($element['is_return']=='yes'){
                                    $return_data=[
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'unit_price'=>$element['unit_price'],
                                        'amount'=>$element['amount'],
                                        'stock_no'=>$element['stock_no'],
                                    ];
                                    array_push($returned_items,$return_data);
                                    $return_amount=$return_amount+$element['amount'];
                                    $item_data=[
                                        'invoice'=>$header->id,
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'unit_price'=>$element['unit_price'],
                                        'discount'=>$element['discount'],
                                        'amount'=>$element['amount'],
                                        'stock_no'=>$element['stock_no'],
                                        'billing_type'=>$element['is_return']
                                    ];
                                    $item_record=new InvoiceItem($item_data);
                                    $item_record->save();
                                }elseif($element['is_return']=='display'){
                                    $item_data=[
                                        'invoice'=>$header->id,
                                        'item'=>$element['item'],
                                        'qty'=>$element['qty'],
                                        'unit_price'=>$element['unit_price'],
                                        'discount'=>$element['discount'],
                                        'amount'=>$element['amount'],
                                        'stock_no'=>$element['stock_no'],
                                        'billing_type'=>$element['is_return']
                                    ];
                                    $item_record=new InvoiceItem($item_data);
                                    $item_record->save();
                                }else{
                                    $qty=0;
                                    while($qty<=$element['qty']){
                                        $item_stock=ItemStock::where('item',$element['item'])->where('qty_in_hand','>',0)->orderBy('id')->first();
                                        $issue_data=[
                                            'vehicle_number'=>$request->vehicle_no,
                                            'item'=>$element['item'],
                                            'qty'=>$item_stock->qty_in_hand,
                                            'stock_no'=>$item_stock->id,
                                            'is_invoiced'=>1,
                                            'invoice'=>$header->id,
                                        ];
                                        $issue=new StockIssue($issue_data);
                                        $issue->save();
                                        $before=$item_stock->qty_in_hand;
                                        $qty=$qty+$item_stock->qty_in_hand;
                                        $item_stock->qty_in_hand=$item_stock->qty_in_hand-$item_stock->qty_in_hand;
                                        $item_stock->save();
                                        $item_qtys=ItemStock::where('item',$element['item'])->sum('qty_in_hand');
                                        $transaction_data=[
                                            'stock_id'=>$item_stock->id,
                                            'item'=>$element['item'],
                                            'transaction_type'=>'sales/stock-issue',
                                            'tran_status'=>'out',
                                            'qih_before'=>$before,
                                            'qih_after'=>$item_stock->qty_in_hand,
                                            'transfer_qty'=>$before,
                                            'reference_id'=>$issue->id,
                                            'total_qih_before'=>$item_qtys+$before,
                                            'total_qih_after'=>$item_qtys,
                                        ];
                                        $transaction=new ItemTransaction($transaction_data);
                                        $transaction->save();
                                        $item_data=[
                                            'invoice'=>$header->id,
                                            'item'=>$element['item'],
                                            'qty'=>$element['qty'],
                                            'unit_price'=>$element['unit_price'],
                                            'discount'=>$element['discount'],
                                            'amount'=>$element['amount'],
                                            'stock_no'=>$item_stock->id,
                                            'billing_type'=>$element['is_return']
                                        ];
                                        $item_record=new InvoiceItem($item_data);
                                        $item_record->save();
                                    }
                                }

                            }
                        }
                    }
                }
            }

            if(sizeof($returned_items)>0){

                $sales_ret_data=[
                    'return_number'=>$this->return_code_create(),
                    'return_amount'=>$return_amount,
                    'invoice_no'=>$header->id,
                    'cashier'=>Auth::user()->id,
                ];
                $sales_return=new SalesReturn($sales_ret_data);
                $sales_return->save();
                $header->return_amount=$header->return_amount+$return_amount;
                $header->save();
                foreach($returned_items as $return){
                    $return_data=[
                        'return_id'=>$sales_return->id,
                        'item'=>$return['item'],
                        'stock'=>$return['stock_no'],
                        'qty'=>$return['qty'],
                        'unit_price'=>$return['unit_price'],
                        'amount'=>$return['amount'],
                    ];
                    $return_detail=new SalesReturnDetail($return_data);
                    $return_detail->save();
                }
            }
            if($request->pay_method=='cheque'){
                $receipt_header=[
                    'recept_no'=>$this->receipt_code_create(),
                    'customer'=>$request->customer,
                    'recept_amount'=>$request->final_total,
                    'payment_type'=>'cheque',
                    'cashier'=>Auth::user()->id,
                ];
                $receipt=new CustomerRecept($receipt_header);
                $receipt->save();
                $receipt_data=[
                    'invoice'=>$header->id,
                    'balance_before'=>$request->final_total,
                    'pay_amount'=>$request->final_total,
                    'balance_after'=>0.00,
                    'recept_id'=>$receipt->id,
                ];
                $detail=new CustomerReceptDetail($receipt_data);
                $detail->save();
                $header->balance=$header->balance-$request->final_total;
                $header->save();
                $cheque_data=[
                    'receipt_id'=>$receipt->id,
                    'customer'=>$receipt->customer,
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
                    'transaction_type'=>'sales-cheque',
                    'reference_id'=>$header->id,
                    'debit_amount'=>0,
                    'credit_amount'=>$detail->pay_amount,
                ];
                $cash=new CashTransaction($cash_data);
                $cash->save();
            }else{
                if($paid_amount<$request->final_total){
                    if($paid_amount>0){
                        $customer=Customer::find($request->customer);
                        $customer->current_balance=$customer->current_balance+($request->final_total-$paid_amount);
                        $customer->save();
                        $cash_data=[
                            'transaction_type'=>'sales-cash',
                            'reference_id'=>$header->id,
                            'debit_amount'=>0,
                            'credit_amount'=>$paid_amount,
                        ];
                        $cash=new CashTransaction($cash_data);
                        $cash->save();
                        $cash_data=[
                            'transaction_type'=>'sales-credit',
                            'reference_id'=>$header->id,
                            'debit_amount'=>0,
                            'credit_amount'=>$request->final_total-$paid_amount,
                        ];
                        $cash=new CashTransaction($cash_data);
                        $cash->save();
                    }else{
                        $cash_data=[
                            'transaction_type'=>'sales-credit',
                            'reference_id'=>$header->id,
                            'debit_amount'=>0,
                            'credit_amount'=>$paid_amount,
                        ];
                        $cash=new CashTransaction($cash_data);
                        $cash->save();
                    }
                }else{
                    $cash_data=[
                        'transaction_type'=>'sales-cash',
                        'reference_id'=>$header->id,
                        'debit_amount'=>0,
                        'credit_amount'=>$paid_amount,
                    ];
                    $cash=new CashTransaction($cash_data);
                    $cash->save();
                }
            }
            DB::commit();
            return redirect(url('/sales/print/'.$header->id))->with('success','Item Sales Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }

    public function receipt_code_create() {
        $max_code=DB::select("select recept_no  from customer_recepts  ORDER BY RIGHT(recept_no , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->invoice_number;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='RCPT'.'-'.sprintf('%010d', intval($new_code) + 1);
        return $new_code;
    }

    public function return_code_create(){
        $max_code=DB::select("select return_number  from sales_returns  ORDER BY RIGHT(return_number , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->invoice_number;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='S-RET'.'-'.sprintf('%010d', intval($new_code) + 1);
        return $new_code;
    }

    public function invoice($id){
        $header=InvoiceHeader::find($id);
        $invoice_items=InvoiceItem::where('invoice',$header->id)->get();
        $invoice_services=InvoiceService::where('invoice',$header->id)->get();
        $invoice_materials=InvoiceMaterial::where('invoice',$header->id)->get();
        $customer=null;
        if(isset($header->customer)){
            $customer=Customer::find($header->customer);
        }
        view()->share('customer',$customer);
        view()->share('header',$header);
        view()->share('items',$invoice_items);
        view()->share('services',$invoice_services);
        view()->share('materials',$invoice_materials);
        return view('pages.sales.print');
    }

    public function print($id){
        $header=InvoiceHeader::find($id);
        $invoice_items=InvoiceItem::where('invoice',$header->id)->where('billing_type','!=','hide-stock')->get();
        $invoice_services=InvoiceService::where('invoice',$header->id)->where('billing_type','!=','hide-stock')->get();
        $invoice_materials=InvoiceMaterial::where('invoice',$header->id)->where('billing_type','!=','hide-stock')->get();
        $customer=null;
        if(isset($header->customer)){
            $customer=Customer::find($header->customer);
        }
        view()->share('customer',$customer);
        view()->share('header',$header);
        view()->share('items',$invoice_items);
        view()->share('services',$invoice_services);
        view()->share('materials',$invoice_materials);
        return view('pages.sales.print');
    }

    public function sales_index(){
        return view('pages.sales.index');
    }

    public function sales_get_all(Request $request){
        $columns = [
            0 =>'invoice_number',
            1 =>'customer',
            2=> 'vehicle_number',
            3=> 'net_amount',
            4=> 'paid_amount',
            5=> 'balance',
        ];
        $totalData = InvoiceHeader::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $invoices = InvoiceHeader::join('customers','invoice_header.customer','=','customers.id')
                    ->select('invoice_header.*','customers.customer_name as customer_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $invoices =  InvoiceHeader::join('customers','invoice_header.customer','=','customers.id')
                        ->select('invoice_header.*','customers.customer_name as customer_name')
                        ->where('invoice_header.invoice_number','LIKE',"%{$search}%")
                        ->orWhere('customers.customer_name', 'LIKE',"%{$search}%")
                        ->orWhere('invoice_header.vehicle_number', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = InvoiceHeader::join('customers','invoice_header.customer','=','customers.id')
                        ->select('invoice_header.*','customers.customer_name as customer_name')
                        ->where('invoice_header.invoice_number','LIKE',"%{$search}%")
                        ->orWhere('customers.customer_name', 'LIKE',"%{$search}%")
                        ->orWhere('invoice_header.vehicle_number', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($invoices) ) {
            foreach ($invoices as $item)
                {
                    $invoice['invoice_number'] = $item->invoice_number;
                    $invoice['customer'] = $item->customer_name;
                    $invoice['vehicle_number'] = $item->vehicle_number;
                    $invoice['net_amount'] = $item->net_amount;
                    $invoice['paid_amount'] = $item->paid_amount;
                    $invoice['balance'] = $item->balance;
                    $invoice['action'] = '<div class="btn-group">
                    <a href="'.url('/sales/invoice/'.$item->id).'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>

                    </div>';
                    $data[] = $invoice;

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
