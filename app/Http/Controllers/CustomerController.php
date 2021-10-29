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
            return back()->withInput()->withErrors('Error..!');
        }
    }
}
