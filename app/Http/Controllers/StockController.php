<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemTransaction;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function open_stock_index(){
        return view('pages.open-stock.index');
    }

    public function open_stock_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'item',
            2=> 'purchase_qty',
            3=> 'cost_price',
            4=> 'sales_price',
        ];
        $totalData = ItemStock::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $item_stocks = ItemStock::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $item_stocks =  ItemStock::where('item','LIKE',"%{$search}%")
                        ->orWhere('purchase_qty', 'LIKE',"%{$search}%")
                        ->orWhere('cost_price', 'LIKE',"%{$search}%")
                        ->orWhere('sales_price', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = ItemStock::where('item','LIKE',"%{$search}%")
                        ->orWhere('purchase_qty', 'LIKE',"%{$search}%")
                        ->orWhere('cost_price', 'LIKE',"%{$search}%")
                        ->orWhere('sales_price', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($item_stocks) ) {
            foreach ($item_stocks as $item)
                {
                    $value = Item::find($item->item);
                    $item_stock['id'] = $item->id;
                    $item_stock['item'] = $value->item_name;
                    $item_stock['purchase_qty'] = $item->purchase_qty;
                    $item_stock['cost_price'] = $item->cost_price;
                    $item_stock['sales_price'] = $item->sales_price;
                    $item_stock['action'] = '<div class="btn-group">
                    <a href="/user/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/user/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $item_stock;

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

    public function open_stock_create(){
        $items = Item::get();
        view()->share('items',$items);
        return view('pages.open-stock._form');
    }

    public function open_stock_store(Request $request){
        try {
            ItemStock::where('item',$request->get('item'))->delete();
            ItemTransaction::where('item',$request->get('item'))->delete();

            $item_stock = new ItemStock();
            $item_stock->item = $request->get('item');
            $item_stock->purchase_qty = $request->get('purchase_qty');
            $item_stock->qty_in_hand = $request->get('purchase_qty');
            $item_stock->cost_price = $request->get('cost_price');
            $item_stock->grn = 0;
            $item_stock->sales_price = $request->get('sales_price');
            $item_stock->sales_rate = ($request->get('sales_price')-$request->get('cost_price'))/$request->get('cost_price');
            $item_stock->stock_type = 'open stock';
            $item_stock->save();

            $transaction = new ItemTransaction();
            $transaction->stock_id = $item_stock->id;
            $transaction->item = $item_stock->item;
            $transaction->transaction_type = 'open stock';
            $transaction->tran_status = 'complete';
            $transaction->qih_before = 0;
            $transaction->qih_after = $item_stock->purchase_qty;
            $transaction->transfer_qty = $item_stock->purchase_qty;
            $transaction->reference_id = $item_stock->id;
            $transaction->save();
            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );
            return redirect('/open-stock/all')->with($notification);
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }
}
