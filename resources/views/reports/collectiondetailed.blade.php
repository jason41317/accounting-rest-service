<!DOCTYPE html>
<html>

<head>
  <title>COLLECTION DETAILED</title>
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

    .collections__table th {
      background-color: lightgray;
      /* height: 20px; */
      padding: 5px 10px;
      /* color: white; */
    }

    .collections__table tbody tr:nth-child(even) {
      background-color: #e8e8e8;
    }
  </style>
</head>

<body>
  @include('includes.header', $company_setting)

  <div class="report__title">COLLECTION REPORT (DETAILED)</div>
  <div class="report__sub-title">PERIOD COVERED: {{ date("m/d/Y", strtotime($date_from)) }} - {{ date("m/d/Y", strtotime($date_to)) }}</div>

  <table class="collections__table w-100 table-border-collapse ">
    <thead>
      <tr>
        <th class="w-10 text-left bordered">
          DATE
        </th>
        <th class="w-15 text-left bordered">
          PAYMENT NO
        </th>
        <th class="w-15 text-left bordered">
          ACK RECEIPT
        </th>
        <th class="w-15 text-right bordered">
          RETAINER'S FEE
        </th>
        <th class="w-10 text-right bordered">
          FILING
        </th>
        <th class="w-10 text-right bordered">
          REMITTANCE
        </th>
        <th class="w-10 text-right bordered">
          OTHERS
        </th>
        <th class="w-15 text-right bordered">
          TOTAL
        </th>
      </tr>
    </thead>
    <tbody>
      @if (!count($collections))
      <tr>
        <td colspan="6" class="text-center p-5 b-right bordered">
          There are no records to show.
        </td>
      </tr>
      @endif
      @foreach ($collections as $collection)
      <tr>
        <td class="text-left p-5 border-y">
          {{ $collection->transaction_date }}
        </td>
        <td class="text-left p-5 border-y">
          {{ $collection->payment_no }}
        </td>
        <td class="text-left p-5 border-y">
          {{ $collection->transaction_no }}
        </td>
        <td class="text-right p-5 border-y">
          {{ number_format($collection->retainers_fee_total, 2) }}
        </td>
        <td class="text-right p-5 border-y">
          {{ number_format($collection->filing_total, 2) }}
        </td>
        <td class="text-right p-5 border-y">
          {{ number_format($collection->remittance_total, 2) }}
        </td>
        <td class="text-right p-5 border-y">
          {{ number_format($collection->others_total, 2) }}
        </td>
        <td class="text-right p-5 border-y">
          {{ number_format($collection->amount, 2) }}
        </td>
      </tr>
      @endforeach
    </tbody>
    @if (count($collections))
    <tr>
      <td colspan="3" class="b-top p-5 font-bold"></td>
      <td class="text-right p-5 bordered font-bold">{{ number_format($collections->sum('retainers_fee_total'), 2) }}</td>
      <td class="text-right p-5 bordered font-bold">{{ number_format($collections->sum('filing_total'), 2) }}</td>
      <td class="text-right p-5 bordered font-bold">{{ number_format($collections->sum('remittance_total'), 2) }}</td>
      <td class="text-right p-5 bordered font-bold">{{ number_format($collections->sum('others_total'), 2) }}</td>
      <td class="text-right p-5 bordered font-bold">{{ number_format($collections->sum('amount'), 2) }}</td>
    </tr>
    @endif
  </table>
</body>

</html>