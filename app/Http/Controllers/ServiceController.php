<?php

namespace App\Http\Controllers;

use App\Models\ServiceMaster;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function service_index(){
        return view('pages.MasterFile.service_master.index');
    }

    public function service_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'service_name',
            2=> 'service_rate',
            3=> 'discount_rate',
        ];
        $totalData = ServiceMaster::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $services = ServiceMaster::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $services =  ServiceMaster::where('service_name','LIKE',"%{$search}%")
                        ->orWhere('service_rate', 'LIKE',"%{$search}%")
                        ->orWhere('discount_rate', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = ServiceMaster::where('service_name','LIKE',"%{$search}%")
                        ->orWhere('service_rate', 'LIKE',"%{$search}%")
                        ->orWhere('discount_rate', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($services) ) {
            foreach ($services as $item)
                {
                    $service['id'] = $item->id;
                    $service['service_name'] = $item->service_name;
                    $service['service_rate'] = $item->service_rate;
                    $service['discount_rate'] = $item->discount_rate;
                    $service['action'] = '<div class="btn-group">
                    <a href="/sevices/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/sevices/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $service;

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

    public function service_crete(){
        return view('pages.MasterFile.service_master._form');
    }

    public function service_store(Request $request){
        try {
            $service = new ServiceMaster();
            $service->service_name = $request->get('service_name');
            $service->service_description = $request->get('service_description');
            $service->service_rate = $request->get('service_rate');
            $service->discount_rate = $request->get('discount_rate');
            $service->save();
            return redirect('/services/all')->with('success','Service Stored Successfully!!!');

        } catch (\Throwable $th) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }

    public function service_view($id){
        $service = ServiceMaster::find($id);
        view()->share('service',$service);
        return view('pages.MasterFile.service_master._form');
    }

    public function service_edit($id){
        $service = ServiceMaster::find($id);
        view()->share('service',$service);
        return view('pages.MasterFile.service_master._form');
    }

    public function service_update(Request $request, $id){
        try {
            $service = ServiceMaster::find($id);
            $service->service_name = $request->get('service_name');
            $service->service_description = $request->get('service_description');
            $service->service_rate = $request->get('service_rate');
            $service->discount_rate = $request->get('discount_rate');
            $service->save();
            return redirect('/services/all')->with('success','Service Updated Successfully!!!');

        } catch (\Throwable $th) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }
}
