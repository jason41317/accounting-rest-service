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
      margin-bottom: 10px;
    }

  </style>
</head>
<body>
  @include('includes.header', $company_setting)
  
  <div class="report__title">CHEQUE VOUCHER</div>
  
</body>
</html>