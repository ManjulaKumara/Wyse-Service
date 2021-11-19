<?php

namespace App\Http\Controllers;

use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Models\User;
use Illuminate\Http\Request;

class SalesReturnController extends Controller
{
    public function sales_return_index(){
        return view('pages.sales.sales_return_index');
    }

    public function sales_return_get_all(Request $request){
        $columns = [
            0 =>'return_number',
            1 =>'invoice_no',
            2=> 'return_amount',
        ];
        $totalData = SalesReturn::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $seles_returns = SalesReturn::join('invoice_header','sales_returns.invoice_no','=','invoice_header.id')
                    ->select('sales_returns.*','invoice_header.invoice_number as invoice_number')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $seles_returns =  SalesReturn::join('invoice_header','sales_returns.invoice_no','=','invoice_header.id')
                        ->select('sales_returns.*','invoice_header.invoice_number as invoice_number')
                        ->where('sales_returns.return_number','LIKE',"%{$search}%")
                        ->orWhere('sales_returns.return_amount', 'LIKE',"%{$search}%")
                        ->orWhere('sales_returns.cashier', 'LIKE',"%{$search}%")
                        ->orWhere('invoice_header.invoice_number', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = SalesReturn::join('invoice_header','sales_returns.invoice_no','=','invoice_header.id')
                        ->select('sales_returns.*','invoice_header.invoice_number as invoice_number')
                        ->where('sales_returns.return_number','LIKE',"%{$search}%")
                        ->orWhere('sales_returns.return_amount', 'LIKE',"%{$search}%")
                        ->orWhere('sales_returns.cashier', 'LIKE',"%{$search}%")
                        ->orWhere('invoice_header.invoice_number', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($seles_returns) ) {
            foreach ($seles_returns as $item)
                {
                    $seles_return['return_number'] = $item->return_number;
                    $seles_return['invoice_no'] = $item->invoice_number;
                    $seles_return['return_amount'] = $item->return_amount;
                    $seles_return['action'] = '<div class="btn-group">
                    <a href="/sales-return/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    </div>';
                    $data[] = $seles_return;

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

    public function sales_return_view($id){
        $return_header = SalesReturn::join('invoice_header','sales_returns.invoice_no','=','invoice_header.id')
                        ->select('sales_returns.*','invoice_header.invoice_number as invoice_number')
                        ->where('sales_returns.id',$id)->first();
        $return_details = SalesReturnDetail::join('items','sales_return_details.item','=','items.id')
                        ->select('sales_return_details.*','items.item_name as item_name')
                        ->where('sales_return_details.return_id','=',$id)->get();
        $user = User::where('id','=',$return_header->cashier)->first();
        view()->share('return_header',$return_header);
        view()->share('return_details',$return_details);
        view()->share('user',$user);
        return view('pages.sales.sales_return_view');
    }
}
