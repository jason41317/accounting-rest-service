<!DOCTYPE html>
<html>

<head>
  <title>Income Statement</title>
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

    .income-statement tr td {
      text-transform: uppercase;
      font-size: 9pt;
    }
  </style>
</head>

<body>
  @include('includes.header', $company_setting)

  <div class="report__title">INCOME STATEMENT</div>
  <div class="report__sub-title">{{ date("m/d/Y", strtotime($date_from)) }} TO {{ date("m/d/Y", strtotime($date_to)) }}</div>
  <table class="income-statement w-100 table-border-collapse ">
    @if (!count($accountTypes))
    <tr>
      <td colspan="3" class="text-center p-5">
        There are no records to show.
      </td>
    </tr>
    @else
    <!-- ACCOUNT TYPE -->
    @php
    $totalIncome = 0;
    $totalExpense = 0;
    $totalOperatingExpense = 0;
    $incomeAccountType = $accountTypes->find(4);
    $expenseAccountType = $accountTypes->find(5);
    $serviceIncomeAccountClassId = $system_setting->service_income_account_class_id;
    $otherIncomeAccountClassId = $system_setting->other_income_account_class_id;
    $operatingExpenseAccountClassId = $system_setting->operating_expense_account_class_id;
    @endphp
    <tr>
      <td colspan="3" class="p-5 font-bold">
        INCOME
      </td>
    </tr>
    @if ($incomeAccountType)
    @foreach ($incomeAccountType->accountClasses->whereIn('id', [$serviceIncomeAccountClassId,$operatingExpenseAccountClassId]) as $accountClass)
    <tr>
      <td colspan="3" class="font-bold" style="padding-left: 30px;">
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
        $sum = $journalEntries->sum('pivot.credit') - $journalEntries->sum('pivot.debit');
        $totalIncome += $sum;
        @endphp
        {{ $sum > 0 ? number_format(abs($sum),2) : '('.number_format(abs($sum),2).')' }}
      </td>
      <td style="width: 18%;"></td>
    </tr>
    @endforeach
    @endforeach
    @endif
    <tr>
      <td class="font-bold font-italic" style="padding-left: 30px; padding-bottom: 15px">
        TOTAL INCOME
      </td>
      <td colspan="2" class="text-right font-bold" style="padding-bottom: 15px">
        {{ $totalIncome > 0 ? number_format(abs($totalIncome),2) : '('.number_format(abs($totalIncome),2).')' }}
      </td>
    </tr>
    <tr>
      <td colspan="3" class="p-5 font-bold">
        LESS: OPERATING EXPENSES
      </td>
    </tr>
    @if ($expenseAccountType)
    @php
    $accountClass = $expenseAccountType->accountClasses->find($operatingExpenseAccountClassId);
    @endphp
    @foreach ($accountClass->accountTitles as $accountTitle)
    @php
    $journalEntries = $accountTitle->journalEntries;
    $sum = $journalEntries->sum('pivot.debit') - $journalEntries->sum('pivot.credit');
    $totalOperatingExpense += $sum;
    $totalExpense += $sum;
    @endphp
    <tr>
      <td style="padding-left: 30px;">
        {{ $accountTitle->name }}
      </td>
      <td class="text-right" style="width: 18%;">
        {{ $sum > 0 ? number_format(abs($sum),2) : '('.number_format(abs($sum),2).')' }}
      </td>
      <td style="width: 18%;"></td>
    </tr>
    @endforeach
    @endif
    <tr>
      <td colspan="2" style="padding-left: 60px;" class="font-bold font-italic">
        TOTAL OPERATING EXPENSE
      </td>
      <td class="text-right font-bold b-bottom">
        {{ $totalOperatingExpense > 0 ? '('.number_format(abs($totalOperatingExpense),2).')' : number_format(abs($totalOperatingExpense),2) }}
      </td>
    </tr>
    <tr>
      <td colspan="2" class="font-bold font-italic" style="padding: 10px 0;">
        TOTAL OPERATING INCOME
      </td>
      <td class="text-right font-bold" style="padding: 10px 0;">
        {{ $totalIncome - $totalOperatingExpense > 0 ? number_format(abs($totalIncome - $totalOperatingExpense),2) : '('.number_format(abs($totalIncome - $totalOperatingExpense),2).')' }}
      </td>
    </tr>
    <tr>
      <td colspan="3" class="p-5 font-bold">
        ADD/LESS: NON-OPERATING OR OTHERS
      </td>
    </tr>
    @php
    $accountClass = $accountTypes->pluck('accountClasses')->flatten()->whereNotIn('id', [$serviceIncomeAccountClassId,$otherIncomeAccountClassId,$operatingExpenseAccountClassId]);
    $totalNonOperatingExpense = 0;
    @endphp
    @foreach ($accountClass->pluck('accountTitles')->flatten() as $accountTitle)
    @php
    $journalEntries = $accountTitle->journalEntries;
    $sum = $journalEntries->sum('pivot.debit') - $journalEntries->sum('pivot.credit');
    $totalNonOperatingExpense += $sum;
    $totalExpense += $sum;
    @endphp
    <tr>
      <td style="padding-left: 30px;">
        {{ $accountTitle->name }}
      </td>
      <td class="text-right" style="width: 18%;">
        {{ $sum > 0 ? '('.number_format(abs($sum),2).')' : number_format(abs($sum),2) }}
      </td>
      <td style="width: 18%;"></td>
    </tr>
    @endforeach
    <tr>
      <td colspan="2" style="padding-left: 60px;" class="font-bold font-italic">
        TOTAL NON-OPERATING OR OTHERS
      </td>
      <td class="text-right font-bold b-bottom">
        {{ $totalNonOperatingExpense > 0 ? '('.number_format(abs($totalNonOperatingExpense),2).')' : number_format(abs($totalNonOperatingExpense),2) }}
      </td>
    </tr>
    <tr>
      <td class="font-bold font-italic" style="padding-top: 15px;">
        NET INCOME/LOSS
      </td>
      <td colspan="2" class="text-right font-bold" style="padding-top: 15px;">
        {{ $totalIncome - $totalExpense > 0 ? number_format(abs($totalIncome - $totalExpense),2) : '('.number_format(abs($totalIncome - $totalExpense),2).')' }}
      </td>
    </tr>
    @endif
  </table>
</body>

</html>