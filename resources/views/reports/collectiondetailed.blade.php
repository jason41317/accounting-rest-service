<!DOCTYPE html>
<html>
<head>
  <title>COLLECTION SUMMARY</title>
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
      margin-bottom: 5px;
    }

    .report__sub-title {
      width: 100%;
      text-align: center;
      font-size: 10;
      margin-bottom: 10px;
    }

    .collections__table-header th {
      background-color: lightgray;
      /* height: 20px; */
      padding: 5px 10px;
    }

  </style>
</head>
<body>
  @include('includes.header', $company_setting)

  <div class="report__title">COLLECTION REPORT (DETAILED)</div>
  <div class="report__sub-title">PERIOD COVERED: {{ date("m/d/Y", strtotime($date_from)) }} -  {{ date("m/d/Y", strtotime($date_to)) }}</div>

  <table class="collections__table-header w-100 bordered table-border-collapse ">
    <tr>
      <th class="w-15 text-left bordered">
        DATE
      </th>
      <th class="w-20 text-left bordered">
        PAYMENT NO
      </th>
      <th class="w-20 text-left bordered">
        TRANSACTION NO
      </th>
      <th class="w-15 text-right  bordered">
        FOR PAYMENT
      </th>
      <th class="w-15 text-right  bordered">
        FOR DEPOSIT
      </th>
      <th class="w-15 text-right  bordered">
        TOTAL AMOUNT
      </th>
    </tr>
    @if (!count($collections))
      <tr>
        <td colspan="6" class="text-center p-5 b-right">
          There are no records to show.
        </td>
      </tr>
    @endif
    <?php $for_payment_total = 0; ?>
    <?php $for_deposit_total = 0; ?>
    <?php $amount_total = 0; ?>

    @foreach ($collections as $collection)
      <tr>
        <td class="text-left p-5 b-right">
          {{ $collection->transaction_date }}
        </td>
        <td class="text-left p-5 b-right">
          {{ $collection->payment_no }}
        </td>
        <td class="text-left p-5 b-right">
          {{ $collection->transaction_no }}
        </td>
        <td class="text-right p-5 b-right">
          {{ number_format($collection->for_payment_amount, 2) }}
        </td>
        <td class="text-right p-5 b-right">
          {{ number_format($collection->for_deposit_amount, 2) }}
        </td>
        <td class="text-right p-5">
          {{ number_format($collection->amount, 2) }}
        </td>
      </tr>

      <?php $for_payment_total += $collection->for_payment_amount; ?>
      <?php $for_deposit_total += $collection->for_deposit_amount; ?>
      <?php $amount_total += $collection->amount; ?>

    @endforeach
    @if (count($collections))
      <tr>
        <td colspan="3" class=" p-5 b-right bordered font-bold"></td>
        <td class="text-right p-5 b-right bordered font-bold">{{ number_format($for_payment_total, 2) }}</td>
        <td class="text-right p-5 b-right bordered font-bold">{{ number_format($for_deposit_total, 2) }}</td>
        <td class="text-right p-5 b-right bordered font-bold">{{ number_format($amount_total, 2) }}</td>
      </tr>
    @endif
  </table>
</body>
</html>