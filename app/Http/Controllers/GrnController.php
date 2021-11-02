<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Item;
use DB;
use DateTime;


class GrnController extends Controller
{
    public function code_Create() {
        $max_code=DB::select("select grn_code  from grn_header  ORDER BY RIGHT(grn_code , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->invoice_number;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='GRN'.'-'.sprintf('%010d', intval($new_code) + 1);
        return $new_code;
    }

    public function create(){
        $grn_code=$this->code_Create();
        view()->share('grn_code',$grn_code);
        $suppliers=Supplier::get();
        view()->share('suppliers',$suppliers);
        $items=Item::where('is_active',1)->get();
        view()->share('items',$items);
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        return view('pages.grn.grn');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();

            DB::commit();
            return redirect()->back()->with('success','Item Sales Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
