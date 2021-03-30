<!DOCTYPE html>
<html>
<head>
  <title>Billing Statement</title>
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <style lang="css">

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
    }
  </style>
</head>
<body>
   @include('includes.header', $company_setting)
  <div class="report__title">STATEMENT OF ACCOUNT</div>

  <table style="border-collapse: collapse;" class="w-100" >
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
    @if(count($charges) <= 20)
    <tr>
      <td class="w-100 bordered" colspan="4"  style="height: 350px; padding: 4px; margin: 0;" valign="top">
        
          <table class="w-100 particulars-table" style="border-collapse: collapse; padding: 0;" >
              @foreach ($charges as $charge)
                <tr>
                  <td class="w-75 particulars-td " colspan="3"  >
                    {{ $charge->name }} 
                  </td>
                  <td class="w-25 particulars-td text-right"  >
                  {{ number_format($charge->pivot->amount, 2) }} 
                  </td>
                </tr>
              @endforeach
          </table>
      </td>
    </tr>
    @else
    <tr>
      <td class="w-100 bordered" colspan="4"  style="height: 350px; padding: 4px; margin: 0;" valign="top">
          <table class="w-100 particulars-table" style="border-collapse: collapse; padding: 0;" >
              @for ($i = 0; $i <= 19; $i++)
                <tr>
                  <td class="w-75 particulars-td " colspan="3"  >
                    {{ $charges[$i]->name }} 
                  </td>
                  <td class="w-25 particulars-td text-right"  >
                  {{ number_format($charges[$i]->pivot->amount, 2) }} 
                  </td>
                </tr>
              @endfor
          </table>
      </td>
    </tr>

    <tr>
      <td class="w-100 bordered" colspan="4"  style="height: 350px; padding: 4px; margin: 0;" valign="top">

          <table class="w-100 particulars-table" style="border-collapse: collapse; padding: 0;" >
              @for ($i = 20; $i < count($charges); $i++)
                <tr>
                  <td class="w-75 particulars-td " colspan="3"  >
                    {{ $charges[$i]->name }} 
                  </td>
                  <td class="w-25 particulars-td text-right "  >
                    {{ number_format($charges[$i]->pivot->amount, 2) }} 
                  </td>
                </tr>
              @endfor
          </table>
      </td>
    </tr>
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

  <!-- <table class="particulars-table">
    <tr class="particulars__table-header">
      <th class="text-left">
        PARTICULARS
      </th>
      <th class="col-amount">
        AMOUNT
      </th>
    </tr>
    <tr>
      <td>
        Balance Forwared - As of March 2021
      </td>
      <td class="text-right">
        20, 000.00
      </td>
    </tr>
    <tr>
      <td>
        TAX
      </td>
      <td class="text-right">
        10, 230.00
      </td>
    </tr>

    <tr>
      <td>
        COR
      </td>
      <td class="text-right">
        5, 871.00
      </td>
    </tr>
      
    <tr>
      <td>
        1606 Tax
      </td>
      <td class="text-right">
        3, 231.00
      </td>
    </tr>

  </table> -->
</body>
</html>