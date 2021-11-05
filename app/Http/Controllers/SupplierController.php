<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function supplier_index(){
        return view('pages.MasterFile.supplier.index');
    }

    public function supplier_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'supplier_name',
            2=> 'email',
            3=> 'telephone',
        ];
        $totalData = Supplier::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $suppliers = Supplier::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $suppliers =  Supplier::where('supplier_name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->orWhere('telephone', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Supplier::where('supplier_name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->orWhere('telephone', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($suppliers) ) {
            foreach ($suppliers as $item)
                {
                    $supplier['id'] = $item->id;
                    $supplier['supplier_name'] = $item->supplier_name;
                    $supplier['email'] = $item->email;
                    $supplier['telephone'] = $item->telephone;
                    $supplier['action'] = '<div class="btn-group">
                    <a href="/suppliers/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/suppliers/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $supplier;

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
            return redirect('/suppliers/all')->with('success','Supplier Stored Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }

    public function supplier_view($id){
        $supplier = Supplier::find($id);
        view()->share('supplier',$supplier);
        return view('pages.MasterFile.supplier._form');
    }

    public function supplier_edit($id){
        $supplier = Supplier::find($id);
        view()->share('supplier',$supplier);
        return view('pages.MasterFile.supplier._form');
    }

    public function supplier_update(Request $request, $id){
        try {
            $supplier = Supplier::find($id);
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
                'message' => 'Successfully Updated!',
                'alert-type' => 'success'
            );
            return redirect('/suppliers/all')->with('success','Supplier Updated Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }
}
