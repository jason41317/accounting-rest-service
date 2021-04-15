<!DOCTYPE html>
<html>

<head>
  <title>Accounts Receivable Report</title>
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

    .clients-header th {
      background-color: lightgray;
      /* height: 20px; */
      padding: 5px 10px;
    }
  </style>
</head>

<body>
  @include('includes.header', $company_setting)

  <div class="report__title">ACCOUNTS RECEIVABLE REPORT</div>
  <div class="report__sub-title">AS OF : {{ date("m/d/Y", strtotime($as_of_date)) }}</div>

  <table class="clients-header w-100 table-border-collapse ">
    <tr>
      <th class="w-75 text-left bordered">
        CLIENT
      </th>
      <th class="w-25 text-right bordered">
        AMOUNT
      </th>
    </tr>
    @if (!count($clients))
    <tr>
      <td colspan="2" class="text-center p-5 b-right">
        There are no records to show.
      </td>
    </tr>
    @endif
    @foreach ($clients as $client)
    <tr>
      <td class="text-left p-5 bordered">
        {{ $client->name }}
      </td>
      <td class="text-right p-5 bordered">
        {{ number_format($client->as_of_balance, 2) }}
      </td>
    </tr>
    @endforeach
    @if(count($clients))
    <tr>
      <td class="font-bold text-right p-5">
        TOTAL RECEIVABLES
      </td>
      <td class="font-bold text-right p-5">
        {{ number_format($clients->sum('as_of_balance'),2) }}
      </td>
    </tr>
    @endif
  </table>
</body>

</html>