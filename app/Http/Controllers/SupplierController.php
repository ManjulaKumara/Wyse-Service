<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Exception;

class SupplierController extends Controller
{
    public function supplier_index(){
        return view('pages.MasterFile.supplier.index');
    }

    public function supplier_create(){
        return view('pages.MasterFile.supplier._form');
    }

    public function supplier_store(Request $request){
        try {
            $supplier = new Supplier();
            $supplier->supplier_name = $request->get('supplier_name');
            $supplier->address = $request->get('address');
            $supplier->telephone = $request->get('telephone');
            $supplier->email = $request->get('email');
            $supplier->mobile = $request->get('mobile');
            $supplier->credit_limit = $request->get('credit_limit');
            $supplier->open_balance = $request->get('open_balance');
            $supplier->current_balance = $request->get('current_balance');
            $supplier->save();
            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );
            return redirect('/suppliers/all')->with($notification);

        } catch (Exception $e) {
            return back()->withInput()->withErrors('Error..!');
        }
    }
}
