<!DOCTYPE html>
<html>

<head>
  <title>Statement of Financial Position</title>
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <style lang="css">
    body {
      margin: 0px;
      padding: 0px;
      font-size: 8pt;
      position: relative;
    }

    .report__title {
      width: 100%;
      text-align: center;
      font-size: 12pt;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .report__sub-title {
      width: 100%;
      text-align: center;
      font-size: 10;
      margin-bottom: 10px;
    }

    .financial-position tr td {
      text-transform: uppercase;
      font-size: 9pt;
    }
  </style>
</head>

<body>
  @include('includes.header', $company_setting)

  <div class="report__title">STATEMENT OF FINANCIAL POSITION</div>
  <div class="report__sub-title">AS OF : {{ date("m/d/Y", strtotime($as_of_date)) }}</div>
  <table class="financial-position w-100 table-border-collapse ">
    @if (!count($accountTypes))
    <tr>
      <td colspan="2" class="text-center p-5 b-right">
        There are no records to show.
      </td>
    </tr>
    @endif
    <!-- ACCOUNT TYPE -->
    @php
    $accountTypeSum = 0;
    $liabilitiesAndEquityTotal = 0;
    @endphp
    @foreach ($accountTypes as $accountType)
    <tr>
      <td colspan="2" class="p-5 font-bold">
        {{ $accountType->name }}
      </td>
    </tr>
    <!-- ACCOUNT CLASS -->
    @php
    $accountClassSum = 0;
    @endphp
    @foreach ($accountType->accountClasses as $accountClass)
    <tr>
      <td colspan="2" class="font-bold" style="padding-left: 30px;">
        {{ $accountClass->name }}
      </td>
    </tr>
    <!-- ACCOUNT TITLE -->
    @foreach ($accountClass->accountTitles as $accountTitle)
    <tr>
      <td style="padding-left: 60px;">
        {{ $accountTitle->name }}
      </td>
      <td class="text-right" style="width: 18%;">
        @php
        $journalEntries = $accountTitle->journalEntries;
        $sum = $journalEntries->sum('pivot.debit') - $journalEntries->sum('pivot.credit');
        $liabilitiesAndEquityTotal += $accountClass->account_type_id !== 1 ? $sum : 0;
        $accountClassSum += $sum;
        @endphp
        {{ $sum > 0 ? number_format(abs($sum),2) : '('.number_format(abs($sum),2).')' }}
      </td>
    </tr>
    @endforeach
    <!-- END ACCOUNT TITLE -->
    <tr>
      <td class="font-bold" style="padding-left: 60px; padding-bottom: 15px;">
        TOTAL {{ $accountClass->name }}
      </td>
      <td class="text-right b-top font-bold" style="padding-bottom: 15px;">
        {{ $accountClassSum >= 0 ? number_format(abs($accountClassSum),2) : '('.number_format(abs($accountClassSum),2).')' }}
      </td>
    </tr>
    @php
    $accountTypeSum += $accountClassSum;
    @endphp
    @endforeach
    <!-- END ACCOUNT CLASS -->
    <tr>
      <td class="font-bold" style="padding-left: 30px; padding-bottom: 15px">
        TOTAL {{ $accountType->name }}
      </td>
      <td class="text-right font-bold" style="padding-bottom: 15px">
        {{ $accountTypeSum >= 0 ? number_format(abs($accountTypeSum),2) : '('.number_format(abs($accountTypeSum),2).')' }}
      </td>
    </tr>
    @endforeach
    <!-- END ACCOUNT TYPE -->
    <tr>
      <td class="font-bold" style="padding-bottom: 15px">
        TOTAL LIABILITIES AND EQUITY
      </td>
      <td class="text-right font-bold" style="padding-bottom: 15px">
        {{ $liabilitiesAndEquityTotal >= 0 ? number_format(abs($liabilitiesAndEquityTotal),2) : '('.number_format(abs($liabilitiesAndEquityTotal),2).')' }}
      </td>
    </tr>
  </table>
</body>

</html>