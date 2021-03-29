<!DOCTYPE html>
<html>
<head>
  <title>Cheque Voucher</title>
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <style lang="css">

    body {
      margin: 0px;
      padding: 0px;
      font-size: 8pt;
      position: relative;
    }

    .report__title{ 
      width: 100%;
      text-align: center;
      font-size: 12pt;
      font-weight: bold;
      margin-bottom: 10px;
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
      padding-left: 5px;
      height: 25px;
    }

    .particulars-total-td {
      height: 30px;
      width: 50%;
      font-weight: bold;
      border: solid 1px black;
      padding-right: 5px;
      text-align: right;
    }

    .particulars-th {
      height: 30px;
      border: solid 1px black;
    }
  

    .payee_table {
      margin-bottom: 20px;
      border-collapse: collapse;
      width: 100%;
    }

    .payee_table-td{
      height: 25px;
    }
    
    .cheque-labels {
      position: absolute;
      color: green;
      font-weight: bold;
    }

    .cheque-payee {
      bottom: 195px;
      left: 115px;
      font-size: 10pt;
    }

    .cheque-amount-words {
      bottom: 165px;
      left: 90px;
      font-size: 10pt;
      text-transform: capitalize;
    }

    .cheque-amount {
      bottom: 198px;
      right: 55px;
      font-size: 10pt;
      text-align: left;
      /* border: solid 1px black; */
      width: 160px;
    }

    .cheque-date {
      bottom: 227px;
      right: 45px;
      font-size: 10pt;
      text-align: left;
      /* border: solid 1px black; */
      width: 160px;
    }
  </style>
</head>
<body>
  @include('includes.header')
  
  @if (boolval($disbursement->is_print_cheque) == 1)
    <div class="cheque-labels cheque-payee">{{ $disbursement->payee}} {{ $disbursement->is_print_cheque }}  </div>
    <div class="cheque-labels cheque-amount-words">** {{ $disbursement->amount_in_words }} Pesos Only ** </div>
    <div class="cheque-labels cheque-amount">{{ number_format($disbursement->cheque_amount, 2) }}</div>
    <div class="cheque-labels cheque-date">{{ date('M d, Y', strtotime($disbursement->cheque_date)) }}</div>
  @endif
  
  <div class="report__title">CHEQUE VOUCHER</div>
  <table class="payee_table">
    <tr>
      <td class="w-50 pr-3">
        <table class="w-100">
          <tr>
            <td class="w-15 payee_table-td">PAYEE: </td>
            <td class="b-bottom payee_table-td">{{ $disbursement->payee }}</td>
          </tr>

          <tr>
            <td class="w-15 payee_table-td">CV NO: </td>
            <td class="b-bottom  payee_table-td">{{ $disbursement->voucher_no }}</td>
          </tr>
        </table>
      </td>
      <td class="w-50 pl-3">
        <table class="w-100">
          <tr>
            <td class="w-25 payee_table-td" >CHEQUE NO: </td>
            <td class="w-75 b-bottom payee_table-td">{{ $disbursement->cheque_no }}</td>
          </tr>
          <tr>
            <td class="w-25 " payee_table-td>DATE: </td>
            <td class="w-75 b-bottom payee_table-td"> {{ date('m/d/Y', strtotime($disbursement->created_at)) }}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <table class="w-100 table-border-collapse">
    <tr>
      <td class="w-50 pr-3" valign="top" >
        <table class="w-100 bordered table-border-collapse">
          <tr>
            <th class="w-50 particulars-th">
              PARTICULARS
            </th>
            <th class="w-50 particulars-th">
              AMOUNT
            </th>
          </tr>

          @for ($i = 0; $i < 20; $i++)
            @if ($i <= count($disbursement->disbursementDetails) -1)
            <tr>
                <td class="particulars-td">
                    {{ $disbursement->disbursementDetails[$i]->particular }}
                </td>
                <td class="text-center b-left">
                  {{ number_format($disbursement->disbursementDetails[$i]->amount , 2)  }}
                </td>
            </tr>
            @else
              <tr>
                <td class="particulars-td"></td>
                <td class="text-center b-left"></td>
              </tr>
            @endif
          @endfor

          <tr>
            <td class="particulars-total-td" >
              TOTAL
            </td>
            <td class="text-center bordered w-50 ">
              {{ number_format($disbursement->cheque_amount , 2) }}
            </td>
          </tr>

        </table>
      </td>
      <td class="w-50 pl-3" valign="top">
        <table class="w-100 bordered table-border-collapse">

          <tr>
            <th class="w-50 particulars-th">
              ACCOUNT TITLES
            </th>
            <th class="w-25 mw-25 particulars-th">
              DEBIT
            </th>
            <th class="w-25 mw-25 particulars-th">
              CREDIT
            </th>
          </tr>



          @for ($i = 0; $i < 19; $i++)
            @if ($i <= count($disbursement->summedAccountTitles) -1)
            <tr>
              <td class="w-50 particulars-td">
                {{ $disbursement->summedAccountTitles[$i]->accountTitle->name}}
              </td>
              <td class="w-25 mw-25 text-center b-left b-right">
                {{ number_format($disbursement->summedAccountTitles[$i]->debit , 2)  }}
              </td>
              <td class="w-25 mw-25 text-center b-left b-right"></td>
            </tr>
            @else
              <tr>
                <td class="particulars-td"></td>
                <td class="text-center b-left"></td>
                <td class="text-center b-left"></td>
              </tr>
            @endif
          @endfor

          <tr>
            <td class="w-50 particulars-td">
              Cash
            </td>
            <td class="w-25 mw-25 text-center b-left b-right">
              
            </td>
            <td class="w-25 mw-25 text-center b-left b-right">
              {{ number_format($disbursement->cheque_amount , 2) }}
            </td>
          </tr>

          <tr>
            <td class="particulars-total-td w-75" colspan="2" >
              TOTAL
            </td>
            <td class="text-center bordered w-25">
              {{ number_format($disbursement->cheque_amount , 2) }}
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>