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

    .collections__table-header th {
      background-color: lightgray;
      /* height: 20px; */
      padding: 5px 10px;
    }
  </style>
</head>

<body>
  @include('includes.header', $company_setting)

  <div class="report__title">COLLECTION REPORT (SUMMARY)</div>
  <div class="report__sub-title">PERIOD COVERED: {{ date("m/d/Y", strtotime($date_from)) }} - {{ date("m/d/Y", strtotime($date_to)) }}</div>

  <table class="collections__table-header w-100  table-border-collapse ">
    <tr>
      <th class="w-20 text-left bordered">
        DATE
      </th>
      <th class="w-15 text-right  bordered">
        RETAINER'S FEE
      </th>
      <th class="w-15 text-right  bordered">
        FILING
      </th>
      <th class="w-15 text-right  bordered">
        REMITTANCE
      </th>
      <th class="w-15 text-right  bordered">
        OTHERS
      </th>
      <th class="w-20 text-right  bordered">
        TOTAL
      </th>
    </tr>
    <tbody>
      @if (!count($collections))
      <tr>
        <td colspan="6" class="text-center p-5 b-right bordered">
          There are no records to show.
        </td>
      </tr>
      @endif
      @foreach ($collections->groupBy('transaction_date') as $key => $collection)
      <tr>
        <td class="text-left p-5 b-right bordered">
          {{ $key }}
        </td>
        <td class="text-right p-5 b-right bordered">
          {{ number_format($collection->sum('retainers_fee_total'), 2) }}
        </td>
        <td class="text-right p-5 b-right bordered">
          {{ number_format($collection->sum('filing_total'), 2) }}
        </td>
        <td class="text-right p-5 bordered">
          {{ number_format($collection->sum('remittance_total'), 2) }}
        </td>
        <td class="text-right p-5 bordered">
          {{ number_format($collection->sum('others_total'), 2) }}
        </td>
        <td class="text-right p-5 bordered">
          {{ number_format($collection->sum('amount'), 2) }}
        </td>
      </tr>
      @endforeach
    </tbody>
    @if (count($collections))
    <tr>
      <td class=" p-5 b-right  font-bold"></td>
      <td class="text-right p-5 b-right bordered font-bold">{{ number_format($collections->sum('retainers_fee_total'), 2) }}</td>
      <td class="text-right p-5 b-right bordered font-bold">{{ number_format($collections->sum('filing_total'), 2) }}</td>
      <td class="text-right p-5 b-right bordered font-bold">{{ number_format($collections->sum('remittance_total'), 2) }}</td>
      <td class="text-right p-5 b-right bordered font-bold">{{ number_format($collections->sum('others_total'), 2) }}</td>
      <td class="text-right p-5 b-right bordered font-bold">{{ number_format($collections->sum('amount'), 2) }}</td>
    </tr>
    @endif
  </table>
</body>

</html>