<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceHeader;


class ReportController extends Controller
{
    public function daily_summary(){
        return view('pages.reports.daily-summary');
    }

    public function fill_data_summary(Request $request){
        $date=$request->date;
        $total_sales=
    }
}
