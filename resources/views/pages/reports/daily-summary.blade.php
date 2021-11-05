
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
        size: 210mm 297mm;
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
                    <p style="font-size: 20px;margin-left:160px;"><b>No. 22, Colombo Road, Embilimeegama, Pilimathalawa. </b><br><span><b style="margin-left: 85px;">TEL: 081-2 575 509 / 077-7 436 279 </b></span></p>
                    <table class="main" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="content-wrap aligncenter" style=" background-color: #fff;"
                                align="left" valign="top">
                                <table width="85%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block aligncenter" align="center" valign="top" colspan="2">
                                            <table class="invoice" style="width: 95%;">

                                                <tr>
                                                    <td width="50%" style="font-family: Arial; font-size: 22px; color:black; vertical-align: top; text-align: center; border-top-width: 1px; border-top-color: rgb(58, 48, 48); border-top-style: solid;border-bottom-width: 1px; border-bottom-color: rgb(58, 48, 48); border-bottom-style: solid; margin: 0; padding: 10px 0;"
                                                        align="center" valign="top"><h3>Daily Summary @if($data) for {{$date}} @endif</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;" valign="middle" colspan="2">
                                                        <table cellpadding="15px" cellspacing="0" style="width: 100%;">
                                                            <tr>
                                                                <td width="50%" colspan="2" style="text-align: left;border-bottom:1px solid grey;border-right:1px dashed grey;">
                                                                    <h5><b>Total Sales: <b></h5>
                                                                </td>


                                                                <td width="50%" colspan="2" style="text-align: right;border-bottom:1px solid grey;">
                                                                    <h5><b>{{number_format($data['total_sales'], 2)}}</b> </h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%" style="text-align: left;border-bottom:1px solid grey;">
                                                                    <h5>Cash Sales: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_cash'], 2)}}
                                                                </td>

                                                                <td width="30%" style="text-align: left;border-bottom:1px solid grey;">
                                                                    <h5>Supplier Voucher Cash: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_voucher_cash'], 2)}}
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td width="30%" style="border-bottom:1px solid grey;">
                                                                    <h5>Cheque Sales: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_cheque'], 2)}}
                                                                </td>

                                                                <td width="30%" style="text-align: left;border-bottom:1px solid grey;">
                                                                    <h5>Supplier Voucher Cheque: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_voucher_cheque'], 2)}}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="30%" style="border-bottom:1px solid grey;">
                                                                    <h5>Credit Sales: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_credit'], 2)}}
                                                                </td>

                                                                <td width="30%" style="text-align: left;border-bottom:1px solid grey;">
                                                                    <h5>Expenses: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_expenses'], 2)}}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="30%" style="border-bottom:1px solid grey;">
                                                                    <h5>Cust Receipt Cash: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_cash_receipts'], 2)}}
                                                                </td>

                                                                <td width="30%" >

                                                                </td>
                                                                <td width="20%">

                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="30%" style="border-bottom:1px solid grey;">
                                                                    <h5>Cust Receipt Cheque: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_cheque_receipts'], 2)}}
                                                                </td>

                                                                <td width="30%" style="border-bottom:1px solid grey;">

                                                                </td>
                                                                <td width="20%" style="border-bottom:1px solid grey;">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%" style="border-bottom:1px solid grey;">
                                                                    <h5>Total Credit Amount: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_cheque_receipts']+$data['total_cash_receipts']+$data['total_credit']+$data['total_cheque']+$data['total_cash'], 2)}}
                                                                </td>

                                                                <td width="30%" style="text-align: left;border-bottom:1px solid grey;">
                                                                    <h5>Total Debit Amount: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-bottom:1px solid grey;">
                                                                    {{number_format($data['total_expenses']+$data['total_voucher_cheque']+$data['total_voucher_cash'], 2)}}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="30%" style="border-bottom:1px solid grey;">
                                                                    <h5>Total Balance Amount: </h5>
                                                                </td>
                                                                <td width="20%" style="text-align: right;border-right:1px dashed grey;border-bottom:1px solid grey;">
                                                                    {{number_format(($data['total_cheque_receipts']+$data['total_cash_receipts']+$data['total_credit']+$data['total_cheque']+$data['total_cash'])-($data['total_expenses']+$data['total_voucher_cheque']+$data['total_voucher_cash']), 2)}}
                                                                </td>

                                                                <td width="30%">

                                                                </td>
                                                                <td width="20%">

                                                                </td>
                                                            </tr>


                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
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
        <a href="/reports" class="btn btn-info">
            <i data-feather="home" class="mr-2"></i> Back to Reports
        </a>
    </td>
</tr>

    </table > <br> <br>

    <!-- ./ email template -->
</div>
@endsection
