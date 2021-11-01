<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemCategorie;
use App\Models\ServiceMaster;
use App\Models\StockIssue;
use DB;
use DateTime;

class SalesController extends Controller
{
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
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        $services=ServiceMaster::get();
        foreach($services as $service){
            $data=[
                'id'=>$service->id,
                'name'=>$service->service_name,
                'category'=>'Service',
                'barcode'=>$service->id,
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
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        $services=ServiceMaster::get();
        foreach($services as $service){
            $data=[
                'id'=>$service->id,
                'name'=>$service->service_name,
                'stock_no'=>0,
                'category'=>'Service',
                'barcode'=>$service->id,
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
                    'unit_price'=>$sales_price->sales_price,
                    'discount'=>($item->discount_rate*$sales_price->sales_price)."",
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
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
            
            DB::commit();
            return redirect(url('/sales/create'))->with('success','Item Sales Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
