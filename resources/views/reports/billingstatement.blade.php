<!DOCTYPE html>
<html>
<head>
  <title>Billing Statement</title>
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <style lang="css">

    @page {
      header: html_pageHeader;
      footer: html_pageFooter;
      margin-top: 150px;
      sheet-size: A5;
      margin-left: 0.3in;
      margin-right: 0.3in;
      margin-bottom: 0.3in;
    }

    body {
      margin: 0px;
      padding: 0px;
      font-size: 8pt;
    }

    .report__title{
      width: 100%;
      text-align: center;
      font-size: 10pt;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .statement-info {
      width: 100%;
      margin-bottom: 10px;
      table-layout: fixed;
    }

    .statement-info > td {
      width: 50%;
    }

    .particulars-table {
      width: 100%;
    }

    .particulars-table td{
      padding: 3px 10px;
    }

    .col-amount {
      width: 30%;
    }

    .particulars__table-header th {
      background-color: lightgray;
      /* height: 20px; */
      padding: 5px 10px;
    }

    .particulars-td {
      padding: 3px 5px;
      height: 15px;
      max-height: 15px;
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

    .item-notes {
      font-size: 6pt;
      font-style: italic;
      /* overflow: hidden; */
      height: 15px;
      white-space: nowrap;
      text-overflow: ellipsis;
      width: 25%;
      max-width: 25%;
    }
  </style>
</head>
<body>
  <htmlpageheader name="pageHeader" style="display:none">
    @include('includes.header', $company_setting)
  </htmlpageheader>

  <htmlpagefooter name="pageFooter" style="display:none">
    <!-- <div class="footer-label footer-page">
      {DATE F j, Y, g:i A}
    </div>
    <div class="footer-label footer-date">
      Page {PAGENO} of {nb}
    </div> -->
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

  <div class="report__title">STATEMENT OF ACCOUNT</div>

  <table style="border-collapse: collapse;" class="w-100">
    <tr>
      <td>
      </td>
      <td ></td>
      <td style="padding: 5px;" class="text-center">SOA NO. :</td>
      <td style="padding: 5px;" class="text-center">{{ $billing->billing_no}}</td>
    </tr>
    <tr >
      <td colspan="2">
        CLIENT NAME:
      </td>
      <td style="padding: 5px;" class="text-center bordered w-25">
        DATE
      </td>
      <td style="padding: 5px;" class="text-center bordered w-25" >
      {{ date('m/d/Y', strtotime($billing->billing_date))}}
      </td>
    </tr>
    <tr>
      <td style="padding: 5px 5px 3px 5px;" colspan="4" class="w-100 b-top b-left b-right">
        <div class="font-bold"> {{ $billing->contract->trade_name }} </div>
      </td>
    </tr>
    <tr>
      <td style="padding: 0px 5px 5px 5px;" colspan="4" class="w-100 b-bottom b-left b-right">
        <div> {{ $billing->contract->billing_address }}</div>
      </td>
    </tr>
    <tr>
      <td class="w-75 text-center b-top b-bottom b-left" colspan="3" style="padding: 5px;">
        PARTICULARS
      </td>
      <td class="w-25 text-center b-top b-bottom b-right" style="padding: 5px;">
        AMOUNT
      </td>
    </tr>
    <tr>
      <td class="w-75 bordered text-left font-bold" colspan="3" style="padding: 5px;">
        AS OF BALANCE ({{ date('M Y', strtotime($period)) }})
      </td>
      <td class="w-25 bordered text-right font-bold" style="padding: 5px;">
        {{ number_format($previous_balance, 2) }}
      </td>
    </tr>

    @php
      $regChargeCount = count($billing['charges']);
      $adjChargeCount = count($billing['adjustmentCharges']);
      $chargesCount = $regChargeCount +  $adjChargeCount;

      $regCharges = $billing['charges'];
      $adjCharges = $adjChargeCount > 0 ? $billing['adjustmentCharges']->prepend(["id" => 0, "name" => "Credit Memo"]) : $billing['adjustmentCharges'] ;
      $allCharges = $regCharges->push(...$adjCharges);
      $allChargesCount = count($allCharges);
      $fillersCount = $allChargesCount > 20 ? (24 - $allChargesCount) : (19 - $allChargesCount);
    @endphp

    @if($allChargesCount > 24)
      <!-- break point for 1st page -->
      @for($i = 0; $i < 24; $i++)
        @if($i === 23)
          <tr>
            <td class="w-50 particulars-td b-bottom b-left" colspan="1" > {{ $allCharges[$i]->name }} </td>
            <td class="w-25 particulars-td b-bottom b-left item-notes" > {{ $allCharges[$i]->name }} </td>
            <td class="w-25 particulars-td b-bottom b-right text-right" > {{ $allCharges[$i]->pivot->amount? number_format($allCharges[$i]->pivot->amount, 2) : '' }} </td>
          </tr>
        @else
          <tr>
            <td class="w-50 particulars-td b-left" colspan="2"  >
              {{ $allCharges[$i]->name }}
            </td>
            <td class="w-25 particulars-td item-notes " >
              {{ $allCharges[$i]->pivot->notes }}
            </td>
            <td class="w-25 particulars-td b-right text-right"  >
              {{ $allCharges[$i]->pivot->amount? number_format($allCharges[$i]->pivot->amount, 2) : '' }}
            </td>
          </tr>
        @endif
      @endfor
    @else
      <!-- can fit to 1st page -->
      @foreach($allCharges as $charge)
        <tr>
          @if ($charge['id'] == 0)
            <td class="w-75 particulars-td b-left font-bold" colspan="3"  >
              {{ $charge['name'] }}
            </td>
            <td class="w-25 particulars-td b-right text-right"></td>
          @else
            <td class="w-50 particulars-td b-left" colspan="2"  >
              {{ $charge['name'] }}
            </td>
            <td class="w-25 particulars-td item-notes" >
              {{ $charge->pivot ? $charge->pivot->notes : '' }}
            </td>
            <td class="w-25 particulars-td b-right text-right"  >
              {{ $charge['id'] == 0 ? 'test' : number_format($charge['pivot']->amount, 2) }}
            </td>
          @endif
        </tr>
      @endforeach

      <!-- filler td's for 1st page -->
      @if ($fillersCount > 0)
        @for ($i = 1; $i <= $fillersCount; $i++)
          @if($i === $fillersCount)
            <tr>
              <td class="w-75 particulars-td b-bottom b-left" colspan="3"  ></td>
              <td class="w-25 particulars-td b-bottom b-right text-right"  ></td>
            </tr>
          @else
          <tr>
            <td class="w-75 particulars-td b-left" colspan="3"  ></td>
            <td class="w-25 particulars-td b-right text-right"  ></td>
          </tr>
          @endif
        @endfor
      @endif
    @endif

    <!-- 2nd page -->
    @if($allChargesCount > 24)

      @php
        $fillers2Count = 25 - ($allChargesCount - 24);
      @endphp
      <tr>
        <td>
        </td>
        <td ></td>
        <td style="padding: 5px;" class="text-center">SOA NO. :</td>
        <td style="padding: 5px;" class="text-center">{{ $billing->billing_no}}</td>
      </tr>
      <tr >
        <td colspan="2">
          CLIENT NAME:
        </td>
        <td style="padding: 5px;" class="text-center bordered w-25">
          DATE
        </td>
        <td style="padding: 5px;" class="text-center bordered w-25" >
        {{ date('m/d/Y', strtotime($billing->billing_date))}}
        </td>
      </tr>
      <tr>
        <td style="padding: 5px 5px 3px 5px;" colspan="4" class="w-100 b-top b-left b-right">
          <div class="font-bold"> {{ $billing->contract->trade_name }} </div>
        </td>
      </tr>
      <tr>
        <td style="padding: 0px 5px 5px 5px;" colspan="4" class="w-100 b-bottom b-left b-right">
          <div> {{ $billing->contract->billing_address }}</div>
        </td>
      </tr>
      <tr>
        <td class="w-75 text-center b-top b-bottom b-left" colspan="3" style="padding: 5px;">
          PARTICULARS
        </td>
        <td class="w-25 text-center b-top b-bottom b-right" style="padding: 5px;">
          AMOUNT
        </td>
      </tr>

      @for($i = 24; $i < $allChargesCount; $i++)
        @if($i === 24)
          <tr>
            <td class="w-50 particulars-td b-top b-left" colspan="2" >
              {{ $allCharges[$i]->name }}
            </td>
            <td class="w-25 particulars-td b-top item-notes" >
              {{ $allCharges[$i]->pivot ? $allCharges[$i]->pivot->notes : '' }}
            </td>
            <td class="w-25 particulars-td b-top b-right text-right" >
              {{ $allCharges[$i]->pivot->amount? number_format($allCharges[$i]->pivot->amount, 2) : '' }}
            </td>
          </tr>
        @else
          <tr>
            <td class="w-50 particulars-td b-left " colspan="2"  >
              {{ $allCharges[$i]->name }}
            </td>
            <td class="w-25 particulars-td  item-notes" >
              {{ $allCharges[$i]->pivot ? $allCharges[$i]->pivot->notes : '' }}
            </td>
            <td class="w-25 particulars-td b-right text-right"  >
              {{ $allCharges[$i]->pivot->amount ? number_format($allCharges[$i]->pivot->amount, 2) : '' }}
            </td>
          </tr>
        @endif
      @endfor
      @if ($fillers2Count > 0)
        @for ($i = 1; $i <= $fillers2Count; $i++)
          @if($i === $fillers2Count)
            <tr>
              <td class="w-75 particulars-td b-bottom b-left" colspan="3"  ></td>
              <td class="w-25 particulars-td b-bottom b-right text-right"  ></td>
            </tr>
          @else
          <tr>
            <td class="w-75 particulars-td b-left" colspan="3"  ></td>
            <td class="w-25 particulars-td b-right text-right"  ></td>
          </tr>
          @endif
        @endfor
      @endif
    @endif

    <tr>
      <td class="w-75 text-right bordered font-bold" colspan="3"  style="padding: 5px"> AMOUNT DUE : </td>
      <td class="w-25 text-right bordered font-bold"  style="padding: 5px"> {{ number_format($billing->amount + $previous_balance, 2) }} </td>
    </tr>

    <tr>
      <td class="w-50 b-left b-right" colspan="2" style="padding: 5px;" valign="top">
        RECEIVED BY:
      </td>
      <td class="w-50 bordered text-center" colspan="2" rowspan="2" style="height: 50px; padding: 5px;" valign="bottom" >
        ATUHORIZED SIGNATURE
      </td>
    </tr>
    <tr>
      <td class="w-50 b-left b-right b-bottom" colspan="2" style="padding: 5px;" valign="top">
        DATE:
      </td>
    </tr>
    <tr>
      <td class="w-100 bordered text-center font-bold" colspan="4" style="padding: 4px;">
        *Kindly ask for an Acknowledgement Receipt
      </td>
    </tr>
  </table>
</body>
</html>