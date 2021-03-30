<div class="w-100">
  <table class="report__header w-100">
      <tr>
        <td class="company__title w-75" colspan="3">{{ $company_setting->company_name }}</td>
        <td class="w-25 text-center" rowspan="4" style="vertical-align: middle;" >
            <img class="logo" src="storage/logo.png" alt="">
        </td>
      </tr>
      <tr>
        <td class="company__sub-title">{{ $company_setting->complete_address }}</td>
      </tr>
      <tr>
        <td class="company__sub-title">Contact Numbers: {{ $company_setting->contact_no }}</td>
      </tr>
      <tr>
        <td class="company__sub-title">Email: {{ $company_setting->email }}</td>
      </tr>
  </table>
</div>
