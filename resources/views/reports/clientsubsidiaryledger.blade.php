<!DOCTYPE html>
<html>

<head>
  <title>Client Subsidiary Ledger</title>
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

    .ledger__table th {
      background-color: lightgray;
      /* height: 20px; */
      padding: 5px 10px;
    }

    .ledger__table tbody tr:nth-child(even) {
      background-color: #e8e8e8;
    }
  </style>
</head>

<body>
  @include('includes.header', $company_setting)

  <div class="report__title">CLIENT SUBSIDIARY LEDGER</div>
  <div class="report__sub-title">AS OF : {{ date("m/d/Y", strtotime($as_of_date)) }}</div>
  <table class="w-100 pb-5">
    <tr>
      <td class="w-15">Client : </td>
      <td class="font-bold">{{ $contract->client->name }}</td>
      <td class="w-15">TIN : </td>
      <td class="font-bold">{{ $contract->tin }}</td>
    </tr>
    <tr>
      <td>Contract No : </td>
      <td class="font-bold">{{ $contract->contract_no }}</td>
      <td>Tradename : </td>
      <td class="font-bold">{{ $contract->trade_name }}</td>
    </tr>
  </table>

  <table class="ledger__table w-100 bordered table-border-collapse ">
    <thead>
      <tr>
        <th class="w-15 text-left bordered">
          DATE
        </th>
        <th class="w-20 text-left bordered">
          REFERENCE
        </th>
        <th class="w-20 text-right bordered">
          BILLING
        </th>
        <th class="w-15 text-right  bordered">
          COLLECTION
        </th>
        <th class="w-15 text-right  bordered">
          BALANCE
        </th>
      </tr>
    </thead>
    <tbody>
      @if (!count($data))
      <tr>
        <td colspan="5" class="text-center p-5 b-right">
          There are no records to show.
        </td>
      </tr>
      @endif
      <?php $balance = 0; ?>

      @foreach ($data as $ledger)
      <tr>
        <td class="text-left p-5 b-right">
          {{ $ledger->reference_date }}
        </td>
        <td class="text-left p-5 b-right">
          {{ $ledger->reference_no }}
        </td>
        <td class="text-right p-5 b-right">
          {{ number_format($ledger->amount, 2) }}
        </td>
        <td class="text-right p-5 b-right">
          {{ number_format($ledger->payment_amount, 2) }}
        </td>
        <td class="text-right p-5 b-right">
          {{ number_format($balance + ($ledger->amount - $ledger->payment_amount), 2) }}
        </td>
      </tr>
      <?php $balance += $ledger->amount - $ledger->payment_amount; ?>
      @endforeach
    </tbody>
  </table>
</body>

</html>