<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Billing;
use App\Models\Disbursement;
use App\Models\DisbursementDetail;
use Illuminate\Http\Request;
use NumberFormatter;
use PHPUnit\TextUI\XmlConfiguration\TestSuite;

class ReportController extends Controller
{
    public function billingStatement(int $billingId)
    {
        
        $billing = Billing::find($billingId);
        
        $billing->append('getAmountAttribute');
        $billing->load(['contract', 'charges', 'adjustmentCharges'])->get();

        //merge charges and adjustment for looping
        $charges = [];
        array_push($charges, ...$billing->charges, ...$billing->adjustmentCharges);

        // todo: get actual previous balance as of < billing date
        $data['previous_balance'] = 0;
        $data['charges'] = $charges;
        $data['billing'] = $billing;

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

        //$data['organization'] = OrganizationSetting::find(1)->load('organizationLogo');
        $content = view('reports.billingstatement')->with($data);
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }

    public function chequeVoucher(Request $request, int $disbursementId)
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        
        $disbursement = Disbursement::find($disbursementId);
        
        $disbursement->load(['disbursementDetails', 'summedAccountTitles' => function($q) {
            return $q->with('accountTitle');
        }])->get();
        

        $disbursement['amount_in_words'] = $formatter->format($disbursement->cheque_amount);
        $disbursement['is_print_cheque'] = $request->is_print_cheque == 'true' ? 1 : 0;

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

        $content = view('reports.chequevoucher')->with('disbursement', $disbursement);
        // $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }
}

