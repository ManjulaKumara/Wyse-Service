<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemTransaction;
use App\Models\ItemDamage;
use DateTime;
use DB;

class DamageController extends Controller
{
    public function create(){
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        $items=Item::where('is_active',1)->get();
        $item_list=[];
        foreach($items as $item){
            $item_qtys=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            if($item_qtys>0){
                $data=[
                    'id'=>$item->id,
                    'name'=>$item->item_name,
                    'barcode'=>$item->barcode,
                    'code'=>$item->item_code,
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        view()->share('item_list',$item_list);
        return view('pages.damges.damages');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $item_stock=null;
            $item_stock=ItemStock::where('item',$request->item)->where('qty_in_hand','>=',$request->damage_quantity)->orderBy('id')->first();
            if($item_stock){
                $damage_data=[
                    'item'=>$request->item,
                    'qty'=>$request->damage_quantity,
                    'stock_no'=>$item_stock->id,
                ];
                $damage=new ItemDamage($damage_data);
                $damage->save();
                $item_stock->qty_in_hand=$item_stock->qty_in_hand-$request->damage_quantity;
                $item_stock->save();
                $item_qtys=ItemStock::where('item',$request->item)->sum('qty_in_hand');
                $transaction_data=[
                    'stock_id'=>$item_stock->id,
                    'item'=>$request->item,
                    'transaction_type'=>'damage',
                    'tran_status'=>'out',
                    'qih_before'=>$item_stock->qty_in_hand+$request->damage_quantity,
                    'qih_after'=>$item_stock->qty_in_hand,
                    'transfer_qty'=>$request->damage_quantity,
                    'reference_id'=>$damage->id,
                    'total_qih_before'=>$item_qtys+$request->damage_quantity,
                    'total_qih_after'=>$item_qtys,
                ];
                $transaction=new ItemTransaction($transaction_data);
                $transaction->save();
            }else{
                $qty=0;
                while($qty<=$request->damage_quantity){
                    $item_stock=ItemStock::where('item',$request->item)->where('qty_in_hand','>',0)->orderBy('id')->first();
                    $damage_data=[
                        'item'=>$request->item,
                        'qty'=>$item_stock->qty_in_hand,
                        'stock_no'=>$item_stock->id,
                    ];
                    $damage=new ItemDamage($damage_data);
                    $damage->save();
                    $before=$item_stock->qty_in_hand;
                    $qty=$qty+$item_stock->qty_in_hand;
                    $item_stock->qty_in_hand=$item_stock->qty_in_hand-$item_stock->qty_in_hand;
                    $item_stock->save();
                    $item_qtys=ItemStock::where('item',$request->item)->sum('qty_in_hand');
                    $transaction_data=[
                        'stock_id'=>$item_stock->id,
                        'item'=>$request->item,
                        'transaction_type'=>'damage',
                        'tran_status'=>'out',
                        'qih_before'=>$before,
                        'qih_after'=>$item_stock->qty_in_hand,
                        'transfer_qty'=>$before,
                        'reference_id'=>$item_stock->id,
                        'total_qih_before'=>$item_qtys+$before,
                        'total_qih_after'=>$item_qtys,
                    ];
                    $transaction=new ItemTransaction($transaction_data);
                    $transaction->save();
                }
            }
            DB::commit();
            return redirect()->back()->with('success','Item Damage Stored Successfully!!!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }

    public function damage_index(){
        return view('pages.damges.index');
    }

    public function damage_get_all(Request $request){
        $columns = [
            0 =>'item',
            1 =>'qty',
            2=> 'created_at',
        ];
        $totalData = ItemDamage::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $damages = ItemDamage::join('items','item_damages.item','=','items.id')
                    ->select('item_damages.*','items.item_name as item_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $damages =  ItemDamage::join('items','item_damages.item','=','items.id')
                        ->select('item_damages.*','items.item_name as item_name')
                        ->where('item_damages.qty','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = ItemDamage::join('items','item_damages.item','=','items.id')
                        ->select('item_damages.*','items.item_name as item_name')
                        ->where('item_damages.qty','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($damages) ) {
            foreach ($damages as $item)
                {
                    $damage['item'] = $item->item_name;
                    $damage['qty'] = $item->qty;
                    $damage['created_at'] = $item->created_at->format('Y-m-d');
                    $data[] = $damage;

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
