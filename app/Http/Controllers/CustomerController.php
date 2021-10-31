<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Exception;

class CustomerController extends Controller
{
    public function customers_index(){
        return view('pages.MasterFile.customers.index');
    }

    public function customers_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'customer_name',
            2=> 'email',
            3=> 'telephone',
        ];
        $totalData = Customer::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $customers = Customer::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $customers =  Customer::where('customer_name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->orWhere('telephone', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Customer::where('customer_name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->orWhere('telephone', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($customers) ) {
            foreach ($customers as $item)
                {
                    $customer['id'] = $item->id;
                    $customer['customer_name'] = $item->customer_name;
                    $customer['email'] = $item->email;
                    $customer['telephone'] = $item->telephone;
                    $customer['action'] = '<div class="btn-group">
                    <a href="/customers/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/customers/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $customer;

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

    public function customers_create(){
        return view('pages.MasterFile.customers._form');
    }

    public function customers_store(Request $request){
        try {
            $customer = new Customer();
            $customer->customer_name = $request->get('customer_name');
            $customer->address = $request->get('address');
            $customer->telephone = $request->get('telephone');
            $customer->email = $request->get('email');
            $customer->mobile = $request->get('mobile');
            $customer->credit_limit = $request->get('credit_limit');
            $customer->open_balance = $request->get('open_balance');
            $customer->current_balance = $request->get('current_balance');
            $customer->save();

            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );
            return redirect('/customers/all')->with($notification);

        } catch (Exception $e) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }

    public function customers_view($id){
        $customer = Customer::find($id);
        view()->share('customer',$customer);
        return view('pages.MasterFile.customers._form');
    }

    public function customers_edit($id){
        $customer = Customer::find($id);
        view()->share('customer',$customer);
        return view('pages.MasterFile.customers._form');
    }

    public function customers_update(Request $request, $id){
        try {
            $customer = Customer::find($id);
            $customer->customer_name = $request->get('customer_name');
            $customer->address = $request->get('address');
            $customer->telephone = $request->get('telephone');
            $customer->email = $request->get('email');
            $customer->mobile = $request->get('mobile');
            $customer->credit_limit = $request->get('credit_limit');
            $customer->open_balance = $request->get('open_balance');
            $customer->current_balance = $request->get('current_balance');
            $customer->save();

            $notification = array(
                'message' => 'Successfully Updated!',
                'alert-type' => 'success'
            );
            return redirect('/customers/all')->with($notification);

        } catch (Exception $e) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }
}
