<!DOCTYPE html>
<html lang="en">
  <head>
    <title>BILLING STATEMENT</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  </head>
  <style lang="css">
    @page :first {
      margin-top: 290px;
    }
    @page {
      margin-top: 290px;
      header: html_pageHeader;
      footer: html_pageFooter;
      /* margin-top: 150px; */
      sheet-size: A5;
      margin-left: 0.3in;
      margin-right: 0.3in;
      margin-bottom: 0.3in;
    }

    body {
      margin: 0px;
      padding: 0px;
      font-size: 7pt;
    }

    .report__title{
      width: 100%;
      text-align: center;
      font-size: 10pt;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .item-name {
      width: 40%;
      padding: 5px;
      /* border: solid 1px black; */
    }

    .item-notes {
      width: 40%;
      padding: 5px;
      font-size: 7pt;
      font-style: italic;
    }

    .item-amount {
      width: 20%;
      padding: 5px;
      text-align: right;
    }

    .table-particulars {
      width: 100%;
      border-collapse: collapse;
      /* table-layout: fixed; */
      border-spacing: 0;
    }

    .table-particulars tr td {
      border-left: solid 1px black;
      border-right: solid 1px black;
    }

    .table-particulars tbody tr:nth-child(21) td  {
      border-bottom: solid 1px black;
    }

    .table-particulars tbody tr:nth-child(42) td  {
      border-bottom: solid 1px black;
    }

    .footer-label {
      position: absolute;
      font-size: 7pt;
    }

    .footer-page {
      left: 28px;
      bottom: 10px;
      width: 50%;
    }

    .footer-date {
      right: 28px;
      bottom: 10px;
      width: 50%;
      text-align: right;
    }

    .client-name {
      font-weight: bold;
    }

    .client-address {
      font-size: 6pt;
    }
  </style>
<body>
  <htmlpageheader name="pageHeader" style="display:none">
    @include('includes.header', $company_setting)
    <table class="w-100" style="border-collapse: collapse; table-layout: fixed; border-spacing: 0;">
      <tr>
        <td class="w-100 report__title" colspan="4" style="text-align: center;">STATEMENT OF ACCOUNT</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td class="text-right w-25 p-5 " >
          SOA NO:
        </td>
        <td class="text-right w-25 p-5 " >
        {{ $billing->billing_no}}
        </td>
      </tr>
      <tr>
        <td colspan="2">
          CLIENT
        </td>
        <td class="text-right w-25 p-5 bordered" >
          DATE:
        </td>
        <td class="text-right w-25 p-5 bordered" >
          {{ date('m/d/Y', strtotime($billing->billing_date))}}
        </td>
      </tr>
      <tr>
        <td class="w-100 b-left b-right b-top client-name" style="padding: 3px 5px;" colspan="4">
          {{ $billing->contract->trade_name }}
        </td>
      </tr>
      <tr rowspan="2">
        <td class="w-100 b-left b-right b-bottom client-address" style="padding: 3px 5px; height: 25px;" colspan="4" valign="top">
          {{ $billing->contract->billing_address }}
        </td>
      </tr>
      <tr>
        <td class="w-75 b-left b-bottom p-5 font-bold" colspan="3">
          FORWARDED BALANCE ({{ date('M Y', strtotime($period)) }})
        </td>
        <td class="w-25 b-left b-bottom p-5 b-right text-right font-bold">
          {{ number_format($previous_balance, 2) }}
        </td>
      </tr>
    </table>
    <table class="w-100" style="border-collapse: collapse; table-layout: fixed; border-spacing: 0;">
      <tr>
        <th class="w-40 b-left b-bottom text-left p-5">PARTICULARS</th>
        <th class="w-40 text-left b-bottom p-5">NOTES</th>
        <th class="w-20 b-right b-bottom text-right p-5">AMOUNT</th>
      </tr>
    </table>
  </htmlpageheader>
  <htmlpagefooter name="pageFooter" style="display:none">
    <table class="w-100">
      <tr>
        <td class="footer-label footer-page">
          {DATE F j, Y, g:i A}
        </td>
        <td class="footer-label footer-date">
          Page {PAGENO} of {nb}
        </td>
      </tr>
    </table>
  </htmlpagefooter>
  <sethtmlpageheader name="pageHeader" value="on" show-this-page="1" />
  <sethtmlpagefooter name="pageFooter" value="on" show-this-page="1"/>
  @php
      $regChargeCount = count($billing['charges']);
      $adjChargeCount = count($billing['adjustmentCharges']);
      $chargesCount = $regChargeCount +  $adjChargeCount;

      $regCharges = $billing['charges'];
      $adjCharges = $adjChargeCount > 0 ? $billing['adjustmentCharges']->prepend(["id" => 0, "name" => "Credit Memo" , "pivot" => null]) : $billing['adjustmentCharges'] ;
      $allCharges = $regCharges->push(...$adjCharges);
      $allChargesCount = count($allCharges);
      $fillersCount = $allChargesCount > 15 ? 0 : (15 - $allChargesCount);
    @endphp
  <table class="table-particulars" >
    <tbody>
      @if ($allChargesCount < 15)
        <!-- fit to 1 page -->
        @foreach($allCharges as $charge)
          <tr>
            <td class="item-name @if($charge['id']===0) font-bold @endif">{{ $charge['name'] }}</td>
            <td class="item-notes">{{ $charge['pivot'] ? Str::limit($charge['pivot']['notes'], 40) : '' }} </td>
            <td class="item-amount">{{ $charge['pivot'] ? number_format($charge['pivot']['amount'], 2) : '' }} </td>
          </tr>
        @endforeach
        @for($i = 0; $i < $fillersCount; $i++)
          <tr>
            <td class="item-name"><span>&emsp;</span></td>
            <td class="item-notes"></td>
            <td class="item-amount"></td>
          </tr>
        @endfor
      @else
        @foreach($allCharges as $charge)
          <tr>
          <td class="item-name @if($charge['id']===0) font-bold @endif">{{ $charge['name'] }}</td>
            <td class="item-notes">{{ $charge['pivot'] ? Str::limit($charge['pivot']['notes'], 40) : '' }} </td>
            <td class="item-amount">{{ $charge['pivot'] ? number_format($charge['pivot']['amount'], 2) : '' }} </td>
          </tr>
        @endforeach
      @endif
    </tbody>
    <tfoot>
      <tr>
        <td class="w-80 text-right b-top p-5 font-bold" colspan="2">
          AMOUNT DUE
        </td>
        <td class="w-20 text-right b-top  p-5 font-bold">
          {{ number_format($billing->amount + $previous_balance, 2) }}
        </td>
      </tr>
    </tfoot>
  </table>
  <table style="border-collapse: collapse; border-spacing: 0; border: solid 1px black; width: 100%;">
    <tr>
      <td class="w-50 p-5">
        RECEIVED BY:
      </td>
      <td class="b-left w-50 p-5 text-center" rowspan="2" valign="bottom">
        AUTHORIZED SIGNATURE
      </td>
    </tr>
    <tr>
      <td  class="w-50 p-5">
        DATE:
      </td>
    </tr>
    <tr>
      <td class="w-100 b-top p-5 text-center font-bold" colspan="2">
        *Kindly ask for an Acknowledgement Receipt
      </td>
    </tr>
  </table>
</body>
</html>