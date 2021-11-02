
@extends('layouts.print')
@section('optional_css')

@endsection
@section('content')
<script>
    function myFunction() {
      window.print();
    }
    </script>
    <style>
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 20px;
  }
  @page
    {
        size: 148mm 210mm;
        /* landscape */
        /* you can also specify margins here: */
        /* for compatibility with both A4 and Letter */
    }

}
        </style>
<div class="m-auto" style="width: 60%;">
    <!-- email template -->
    <table id="section-to-print" width="40%" style="font-family: Arial; font-size: 14px; background-color: #fff; margin: 0;width:100%;">
        <tr>

            <td class="container" valign="top" >
                <div class="content">
                    <h2 style="font-family: Copperplate, Fantasy;color:black; font-size: 45px;margin-left:15px;">
                        <b>DIAMOND SERVICE STATION (PVT) LIMITED.</b>
                    </h2>
                    <p style="font-size: 20px;margin-left:160px;"><b>No. 22, Colombo Road, Embiligama, Pilimathalawa. </b><br><span><b style="margin-left: 85px;">TEL: 081-2 575 509 / 077-7 436 279 </b></span></p>
                    <table class="main" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="content-wrap aligncenter" style=" background-color: #fff;"
                                align="left" valign="top">
                                <table width="85%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block aligncenter" align="center" valign="top" colspan="2">
                                            <table class="invoice" style="width: 95%;">
                                                <tr>
                                                    <td width="60%" style="font-family: Arial; font-size: 15px; color:black; word-wrap: break-word;"
                                                        valign="top">
                                                        <p style="font-size: 17px;"><b>Vehicle No: {{$header->vehicle_number}} </b><br><b>Type: LORRY</b></p>
                                                    </td>
                                                    <td width="40%" style="font-family: Arial; font-size: 15px; color:black; word-wrap: break-word;"
                                                        valign="top" align="right">
                                                        <p style="font-size: 17px;"><b>Inv. Date: {{$header->created_at}}</b></p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td width="50%" style="font-family: Arial; font-size: 20px; color:black; vertical-align: top; border-top-width: 1px; border-top-color: rgb(58, 48, 48); border-top-style: solid;border-bottom-width: 1px; border-bottom-color: rgb(58, 48, 48); border-bottom-style: solid; margin: 0; padding: 10px 0;"
                                                        valign="top">
                                                        @if(isset($header->customer))
                                                            @php
                                                                $customer=App\Models\Customer::find($header->customer);
                                                            @endphp
                                                            <p style="font-size: 17px;"><b>Customer: {{$customer->customer_name}} </b></p>
                                                        @endif
                                                    </td>
                                                    <td width="50%" class="alignright"
                                                        style="font-family: Arial; font-size: 22px; color:black; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: rgb(58, 48, 48); border-top-style: solid;border-bottom-width: 1px; border-bottom-color: rgb(58, 48, 48); border-bottom-style: solid; margin: 0; padding: 10px 0;"
                                                        align="right" valign="top"><b>{{$header->invoice_number}}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;" valign="middle" colspan="2">
                                                        <table cellpadding="8" cellspacing="0" style="width: 100%;">
                                                            <tr>
                                                                <th width="60%" style="border-bottom-width: 1px; border-bottom-color: rgb(58, 48, 48); border-bottom-style: solid;">
                                                                   <p style="font-size:18px;">Item/Service</p>
                                                                </th>
                                                                <th width="15%" style="text-align:left;border-bottom-width: 1px; border-bottom-color: rgb(58, 48, 48); border-bottom-style: solid;">
                                                                   <p style="font-size:18px;">Unit Price
                                                                </th>
                                                                <th width="10%" style="text-align:right;border-bottom-width: 1px; border-bottom-color: rgb(58, 48, 48); border-bottom-style: solid;">
                                                                    <p style="font-size:18px;">Quantity</p>
                                                                </th>
                                                                <th width="15%" align="right" style="text-align:right;border-bottom-width: 1px; border-bottom-color: rgb(58, 48, 48); border-bottom-style: solid;">
                                                                    <p style="font-size:18px;">Amount</p>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td width="60%">
                                                                    <br>
                                                                </td>
                                                                <td width="15%" style="text-align: right;border-right:1px dashed grey;">
                                                                    <br>
                                                                </td>
                                                                <td width="10%" style="text-align: right;border-right:1px dashed grey;">
                                                                    <br>
                                                                </td>
                                                                <td width="15%" style="text-align: right;">
                                                                    <br>
                                                                </td>
                                                            </tr>
                                                            @foreach($items as $item)
                                                            @php
                                                                $element=App\Models\Item::find($item->item);
                                                            @endphp
                                                            <tr style="padding-bottom: 15px;">
                                                                <td width="60%" valign="top" style="font-size: 17px;">
                                                                    <b>{{$element->item_name}}</b>
                                                                </td>
                                                                <td width="15%" style="text-align: right;font-size: 15px;border-right:1px dashed grey;">
                                                                    <b>{{number_format($item->unit_price-$item->discount,2,'.','')}}</b>
                                                                </td>
                                                                <td width="10%" style="text-align: right;font-size: 17px;border-right:1px dashed grey;">
                                                                    <b>{{$item->qty}}</b>
                                                                </td>
                                                                <td width="15%" style="text-align: right;font-size: 17px;">
                                                                    <b>{{number_format($item->amount,2,'.','')}}</b>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @foreach($services as $service)
                                                            <tr>
                                                                <td width="60%" valign="top" style="font-size: 17px;">
                                                                    <b>XXXXXXXXXXXX</b>
                                                                </td>
                                                                <td width="15%" style="text-align: right;font-size: 15px;border-right:1px dashed grey;">
                                                                    <b>450.00</b>
                                                                </td>
                                                                <td width="10%" style="text-align: right;font-size: 17px;border-right:1px dashed grey;">
                                                                    <b>1</b>
                                                                </td>
                                                                <td width="15%" style="text-align: right;font-size: 17px;">
                                                                    <b>450.00</b>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td width="60%" style="border-bottom:1px solid grey;">
                                                                    <br>
                                                                </td>
                                                                <td width="15%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    <br>
                                                                </td>
                                                                <td width="10%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    <br>
                                                                </td>
                                                                <td width="15%" style="text-align: right;border-bottom:1px solid grey;">
                                                                    <br>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="85%" colspan="3" style="text-align: right;border-right:1px dashed grey;">
                                                                    <p style="font-size:18px;"><b>Total</b></p>
                                                                </td>
                                                                <td width="15%" style="text-align: right;">
                                                                    <p style="font-size:18px;"><b>{{$header->total_amount}}</b></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="85%" colspan="3" style="text-align: right;border-right:1px dashed grey;">
                                                                    <p style="font-size:18px;"><b>Discount</b></p>
                                                                </td>
                                                                <td width="15%" style="text-align: right;">
                                                                    <p style="font-size:18px;"><b>{{$header->discount_amount}}</b></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="85%" colspan="3" style="text-align: right;border-right:1px dashed grey;">
                                                                    <p style="font-size:18px;"><b>Net Total</b></p>
                                                                </td>
                                                                <td width="15%" style="text-align: right;">
                                                                    <p style="font-size:18px;"><b>{{$header->net_amount}}</b></p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block aligncenter" colspan="2"
                                            style="font-family: Arial; font-size: 14px; color:black; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;"
                                            align="center" valign="top">
                                            <b>Please ask for a receipt for every payment you make.</b>
                                        </td>
                                    </tr>
                                </table>

                                <!--end table-->
                            </td>
                        </tr>
                    </table>

                </div>
            </td>
        </tr>
    </table>
    <table  style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #eaf0f7; margin: 0;"bgcolor="#eaf0f7">
<tr style="
text-align: center;
">
    <td>
        <button onclick="myFunction()" class="btn btn-success">
            <i data-feather="printer" class="mr-2"></i> Print
        </button> </td>
    <td>
        <a href="/students" class="btn btn-info">
            <i data-feather="home" class="mr-2"></i> Back to Sales
        </a>
    </td>
</tr>

    </table > <br> <br>

    <!-- ./ email template -->
</div>
@endsection
