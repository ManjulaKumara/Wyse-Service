
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
        size: 110mm 140mm; /* landscape */
        /* you can also specify margins here: */

        /* for compatibility with both A4 and Letter */
    }

}
        </style>
<div class="w-50 m-auto">
    <!-- email template -->
    <table id="section-to-print" class="body-wrap" style="font-family: Arial; font-size: 14px; background-color: #fff; margin: 0;">
        <tr>
            <td valign="top"></td>
            <td class="container"

                valign="top">
                <div class="content" >
                    <table class="main" cellpadding="0" cellspacing="0" width="100%">
                        <tr width="100%">
                            <td class="content-wrap aligncenter" style=" background-color: #fff;"
                                align="center" valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding-bottom: 20px; " align="center" colspan="2"><h2 style="font-family: Arial;color:black; font-size: 25px;"><b>Diamond Service Center</b></h2>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="content-block aligncenter"
                                            align="center" valign="top" colspan="2">
                                            <table class="invoice" style="width: 100%;">
                                                <tr>
                                                    <td style="font-family: Arial; font-size: 15px; color:black; word-wrap: break-word;"
                                                        valign="top"><b>Reg Number </b>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td style="font-family: Arial; font-size: 15px; color:black; word-wrap: break-word;"
                                                        valign="top"><b>Customer,<br> Address </b>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;" valign="top">
                                                        <table class="invoice-items" cellpadding="0"
                                                               cellspacing="0" style="width: 100%;">


                                                            <tr>
                                                                <td style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;"
                                                                    valign="top">Date: Payment Date
                                                                </td>
                                                                <td class="alignright"
                                                                    style="font-family: Arial; font-size: 14px; color:black; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;"
                                                                    align="right" valign="top"><b>Invoice</b>
                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td class="alignright" colspan="2" width="100%"
                                                                    style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;"
                                                                    align="right" valign="top">Pay amount LKR
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="alignright" style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; text-align: right; border-top-width: 0px; border-top-color: #50649c; border-top-style: solid; border-bottom-color: #50649c; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 10px 0;"
                                                                align="right">Total
                                                                </td>
                                                                <td class="alignright"
                                                                    style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;"
                                                                    align="right" valign="top">total LKR
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="alignright" style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; text-align: right; border-top-width: 0px; border-top-color: #50649c; border-top-style: solid; border-bottom-color: #50649c; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 10px 0;"
                                                                align="right">Paid
                                                                </td>
                                                                <td class="alignright"
                                                                    style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;"
                                                                    align="right" valign="top">paid LKR
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="alignright" width="80%"
                                                                    style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #50649c; border-top-style: solid; border-bottom-color: #50649c; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 10px 0;"
                                                                    align="right" valign="top">Due Balance
                                                                </td>
                                                                <td class="alignright"
                                                                    style="font-family: Arial; font-size: 15px; color:black; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #50649c; border-top-style: solid; border-bottom-color: #50649c; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 10px 0;"
                                                                    align="right" valign="top">balance LKR
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
                                            align="center" valign="top">Address & Contact
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block aligncenter" colspan="2"
                                            style="font-family: Arial; font-size: 14px; color:black; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;"
                                            align="center" valign="top"><b>Please ask for a receipt for every payment you make. <br/> Advanced are not refundable.</b>
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
        <button onclick="myFunction()" class="btn btn-success m-l-5">
            <i data-feather="printer" class="mr-2"></i> Print
        </button> </td>
    <td>
        <a href="/students" class="btn btn-info m-l-5">
            <i data-feather="home" class="mr-2"></i> Back to Sales
        </a>
    </td>
</tr>

    </table > <br> <br>

    <!-- ./ email template -->
</div>
@endsection
