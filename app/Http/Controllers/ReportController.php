<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use NumberFormatter;
use App\Models\Billing;
use App\Models\Payment;
use App\Models\Disbursement;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Models\DisbursementDetail;
use PHPUnit\TextUI\XmlConfiguration\TestSuite;

class ReportController extends Controller
{
    public function billingStatement(int $billingId)
    {

        //get company setting data
        $companySetting = CompanySetting::find(1);

        $billing = Billing::find($billingId);
        $period = $billing->year . '-' . $billing->month_id . '-' . $billing->cutoff_day;
        
        $billing->append('amount');
        $billing->load(['contract', 'charges', 'adjustmentCharges'])->get();

        $totalPreviousBalance = Billing::whereRaw("DATE(CONCAT(year," . "'-'" . ",month_id," . "'-01')) < DATE('" . $period . "')")
                            ->where('contract_id', $billing->contract_id)->get()
                            ->sum('amount');
        
        $totalPayment = Payment::where('transaction_date', '<=', $period)
                    ->where('contract_id',$billing->contract_id)->get()
                    ->sum('amount');


        //merge charges and adjustment for looping
        $charges = [];
        array_push($charges, ...$billing->charges, ...$billing->adjustmentCharges);

        // todo: get actual previous balance as of < billing date
        $data['previous_balance'] = $totalPreviousBalance - $totalPayment;
        $data['charges'] = $charges;
        $data['billing'] = $billing;
        $data['period'] = $period;
        $data['company_setting'] = $companySetting;

        $mpdf = new Mpdf([
            'default_font_size' => 12,
            'default_font' => 'DejaVuSans'
        ]);

        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO} of {nbpg}');
        //$mpdf->AddPage('','','','','off','','','','','','','','','','','','','','','','A5');
        $mpdf->AddPageByArray(
            array(
                'orientation' => 'P',
                'suppress' => 'off',
                'sheet-size' => 'A5',
                'margin-left' => '7.62',
                'margin-top' => '7.62',
                'margin-bottom' => '7.62',
                'margin-right' => '7.62'
            )
        );

        // return $data;

        //$data['organization'] = OrganizationSetting::find(1)->load('organizationLogo');
        $content = view('reports.billingstatement')->with($data);
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }

    public function chequeVoucher(Request $request, int $disbursementId)
    {
        //get company setting data
        $companySetting = CompanySetting::find(1);

        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        
        $disbursement = Disbursement::find($disbursementId);
        
        $disbursement->load(['disbursementDetails', 'summedAccountTitles' => function($q) {
            return $q->with('accountTitle');
        }])->get();
        
        $data['disbursement'] = $disbursement;
        $data['amount_in_words'] = $formatter->format($disbursement->cheque_amount);
        $data['is_print_cheque'] = $request->is_print_cheque == 'true' ? 1 : 0;
        $data['company_setting'] = $companySetting;

        $mpdf = new Mpdf([
            'default_font_size' => 12,
            'default_font' => 'DejaVuSans'
        ]);

        $mpdf->defaultfooterline = 0;
        //$mpdf->setFooter('{PAGENO} of {nbpg}');
        //$mpdf->AddPage('','','','','off','','','','','','','','','','','','','','','','A5');
        $mpdf->AddPageByArray(
            array(
                'orientation' => 'P',
                'suppress' => 'off',
                'sheet-size' => 'A4',
                'margin-left' => '7.62',
                'margin-top' => '7.62',
                'margin-bottom' => '7.62',
                'margin-right' => '7.62'
            )
        );

        //$data['organization'] = OrganizationSetting::find(1)->load('organizationLogo');

        $content = view('reports.chequevoucher')->with($data);
        // $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }
}

