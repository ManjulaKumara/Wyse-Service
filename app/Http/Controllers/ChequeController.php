<?php

namespace App\Http\Controllers;

use App\Models\CustomerCheque;
use App\Models\SupplierCheque;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    public function customer_cheque_index(){
        return view('pages.customer-cheque.index');
    }

    public function customer_cheque_get_all(Request $request){
        $columns = [
            0 =>'receipt_id',
            1 =>'customer',
            2=> 'cheque_number',
            3=> 'bank_name',
            4=> 'banked_date',
            5=> 'cheque_amount',
        ];
        $totalData = CustomerCheque::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $customer_cheques = CustomerCheque::join('customers','customer_cheques.customer','=','customers.id')
                    ->join('customer_recepts', 'customer_cheques.receipt_id','=','customer_recepts.id')
                    ->select('customer_cheques.*','customers.customer_name as customer_name','customer_recepts.recept_no as recept_no')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $customer_cheques = CustomerCheque::join('customers','customer_cheques.customer','=','customers.id')
                    ->join('customer_recepts', 'customer_cheques.receipt_id','=','customer_recepts.id')
                    ->select('customer_cheques.*','customers.customer_name as customer_name','customer_recepts.recept_no as recept_no')
                    ->where('customer_recepts.recept_no','LIKE',"%{$search}%")
                    ->orWhere('customer_cheques.cheque_number', 'LIKE',"%{$search}%")
                    ->orWhere('customer_cheques.banked_date', 'LIKE',"%{$search}%")
                    ->orWhere('customers.customer_name', 'LIKE',"%{$search}%")
                    ->orWhere('customer_cheques.cheque_amount', 'LIKE',"%{$search}%")
                    ->orWhere('customer_cheques.bank_name', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = CustomerCheque::join('customers','customer_cheques.customer','=','customers.id')
                        ->join('customer_recepts', 'customer_cheques.receipt_id','=','customer_recepts.id')
                        ->select('customer_cheques.*','customers.customer_name as customer_name','customer_recepts.recept_no as recept_no')
                        ->where('customer_recepts.recept_no','LIKE',"%{$search}%")
                        ->orWhere('customer_cheques.cheque_number', 'LIKE',"%{$search}%")
                        ->orWhere('customer_cheques.banked_date', 'LIKE',"%{$search}%")
                        ->orWhere('customers.customer_name', 'LIKE',"%{$search}%")
                        ->orWhere('customer_cheques.cheque_amount', 'LIKE',"%{$search}%")
                        ->orWhere('customer_cheques.bank_name', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($customer_cheques) ) {
            foreach ($customer_cheques as $value)
                {
                    $customer_cheque['receipt_id'] = $value->recept_no;
                    $customer_cheque['customer'] = $value->customer_name;
                    $customer_cheque['cheque_number'] = $value->cheque_number;
                    $customer_cheque['bank_name'] = $value->bank_name;
                    $customer_cheque['banked_date'] = $value->banked_date;
                    $customer_cheque['cheque_amount'] = $value->cheque_amount;

                    $data[] = $customer_cheque;

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

    public function supplier_cheque_index(){
        return view('pages.supplier-cheque.index');
    }

    public function supplier_cheque_get_all(Request $request){
        $columns = [
            0 =>'voucher_id',
            1 =>'supplier',
            2=> 'cheque_no',
            3=> 'account',
            4=> 'bank',
            5=> 'cheque_date',
            6=> 'amount',
        ];
        $totalData = SupplierCheque::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $supplier_cheques = SupplierCheque::join('supplier','supplier_cheques.supplier','=','supplier.id')
                    ->join('supplier_vouchers','supplier_cheques.voucher_id','=','supplier_vouchers.id')
                    ->select('supplier_cheques.*','supplier.supplier_name as supplier_name','supplier_vouchers.voucher_number as voucher_number')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $supplier_cheques = SupplierCheque::join('supplier','supplier_cheques.supplier','=','supplier.id')
                    ->join('supplier_vouchers','supplier_cheques.voucher_id','=','supplier_vouchers.id')
                    ->select('supplier_cheques.*','supplier.supplier_name as supplier_name','supplier_vouchers.voucher_number as voucher_number')
                    ->where('supplier_vouchers.voucher_number','LIKE',"%{$search}%")
                    ->orWhere('supplier_cheques.cheque_no', 'LIKE',"%{$search}%")
                    ->orWhere('supplier_cheques.account', 'LIKE',"%{$search}%")
                    ->orWhere('supplier.supplier_name', 'LIKE',"%{$search}%")
                    ->orWhere('supplier_cheques.bank', 'LIKE',"%{$search}%")
                    ->orWhere('supplier_cheques.cheque_date', 'LIKE',"%{$search}%")
                    ->orWhere('supplier_cheques.amount', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = SupplierCheque::join('supplier','supplier_cheques.supplier','=','supplier.id')
                        ->join('supplier_vouchers','supplier_cheques.voucher_id','=','supplier_vouchers.id')
                        ->select('supplier_cheques.*','supplier.supplier_name as supplier_name','supplier_vouchers.voucher_number as voucher_number')
                        ->where('supplier_vouchers.voucher_number','LIKE',"%{$search}%")
                        ->orWhere('supplier_cheques.cheque_no', 'LIKE',"%{$search}%")
                        ->orWhere('supplier_cheques.account', 'LIKE',"%{$search}%")
                        ->orWhere('supplier.supplier_name', 'LIKE',"%{$search}%")
                        ->orWhere('supplier_cheques.bank', 'LIKE',"%{$search}%")
                        ->orWhere('supplier_cheques.cheque_date', 'LIKE',"%{$search}%")
                        ->orWhere('supplier_cheques.amount', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($supplier_cheques) ) {
            foreach ($supplier_cheques as $value)
                {
                    $supplier_cheque['voucher_id'] = $value->voucher_number;
                    $supplier_cheque['supplier'] = $value->supplier;
                    $supplier_cheque['cheque_no'] = $value->cheque_no;
                    $supplier_cheque['account'] = $value->account;
                    $supplier_cheque['bank'] = $value->bank;
                    $supplier_cheque['cheque_date'] = $value->cheque_date;
                    $supplier_cheque['amount'] = $value->amount;

                    $data[] = $supplier_cheque;

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
