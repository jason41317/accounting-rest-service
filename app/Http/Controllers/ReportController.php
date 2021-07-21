<?php

namespace App\Http\Controllers;

use App\Models\AccountTitle;
use App\Models\AccountType;
use Mpdf\Mpdf;
use NumberFormatter;
use App\Models\Billing;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Disbursement;
use Illuminate\Http\Request;
use App\Models\PaymentCharge;
use App\Models\CompanySetting;
use App\Models\Contract;
use App\Models\DisbursementDetail;
use App\Models\JournalEntry;
use App\Models\SystemSetting;
use App\Services\ClientService;
use App\Services\ContractService;
use Illuminate\Support\Facades\DB;
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

        $totalPreviousBalance = Billing::whereRaw("DATE(CONCAT(year,'-',month_id,'-'," . "cutoff_day)) < DATE('" . $period . "')")
                            ->where('contract_id', $billing->contract_id)->get()
                            ->sum('amount');

        $totalPayment = Payment::where('transaction_date', '<=', $period)
                    ->where('contract_id',$billing->contract_id)->get()
                    ->sum('amount');


        //merge charges and adjustment for looping
        // $charges = [];
        // array_push($charges, ...$billing->charges, ...$billing->adjustmentCharges);

        // todo: get actual previous balance as of < billing date
        $data['previous_balance'] = $totalPreviousBalance - $totalPayment;
        // $data['charges'] = $charges;
        $data['billing'] = $billing;
        $data['period'] = $period;
        $data['company_setting'] = $companySetting;

        $mpdf = new Mpdf([
            'default_font_size' => 12,
            'default_font' => 'DejaVuSans'
        ]);

        $mpdf->defaultfooterline = 0;
        // $mpdf->setFooter('{PAGENO} of {nbpg}');
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
        $data['is_print_voucher'] = $request->is_print_voucher == 'true' ? 1 : 0;
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

    public function collectionSummary(Request $request)
    {
        //get company setting data
        $companySetting = CompanySetting::find(1);
        $dateFrom = $request->date_from ? date("Y-m-d", strtotime($request->date_from)) : false;
        $dateTo = $request->date_to ? date("Y-m-d", strtotime($request->date_to)) : false;
        $personnelId = $request->personnel_id ?? false;
        $paymentApproveStatusId = 2;

        $collections = Payment::where('payment_status_id', $paymentApproveStatusId)
        ->when($dateFrom, function ($q) use ($dateFrom, $dateTo) {
            return $q->whereBetween('transaction_date', [$dateFrom, $dateTo]);
        })
        ->when($personnelId, function ($q) use ($personnelId) {
            return $q->whereHas('contract', function ($q) use ($personnelId) {
                return $q->whereHas('assignees', function ($q) use ($personnelId){
                    return $q->where('personnel_id', $personnelId)
                        ->where('is_active', 1);
                });
            });
        })
        ->get();

        $collections->append(['retainers_fee_total', 'filing_total', 'remittance_total', 'others_total']);

        $data['company_setting'] = $companySetting;
        $data['collections'] = $collections;
        $data['date_from'] = $dateFrom;
        $data['date_to'] = $dateTo;

        $mpdf = new Mpdf([
            'default_font_size' => 12,
            'default_font' => 'DejaVuSans'
        ]);

        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO} of {nbpg}');
        $mpdf->AddPageByArray(
            array(
                'orientation' => 'L',
                'suppress' => 'off',
                'sheet-size' => 'A4',
                'margin-left' => '7.62',
                'margin-top' => '7.62',
                'margin-bottom' => '7.62',
                'margin-right' => '7.62'
            )
        );

        //$data['organization'] = OrganizationSetting::find(1)->load('organizationLogo');

        $content = view('reports.collectionsummary')->with($data);
        // $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML($content);
        // return $mpdf->Output();
        return $mpdf->Output('', 'S');
    }

    public function collectionDetailed(Request $request)
    {
        //get company setting data

        $dateFrom = $request->date_from ? date("Y-m-d", strtotime($request->date_from)) : false;
        $dateTo = $request->date_to ? date("Y-m-d", strtotime($request->date_to)) : false;

        $companySetting = CompanySetting::find(1);
        $paymentApproveStatusId = 2;
        $collections = Payment::where('payment_status_id', $paymentApproveStatusId)
                ->when($dateFrom, function($q) use($dateFrom, $dateTo) {
                    return $q->whereBetween('transaction_date', [$dateFrom, $dateTo]);
                })->get();

        $collections->append(['retainers_fee_total', 'filing_total', 'remittance_total', 'others_total']);

        $data['company_setting'] = $companySetting;
        $data['collections'] = $collections;
        $data['date_from'] = $dateFrom;
        $data['date_to'] = $dateTo;

        $mpdf = new Mpdf([
            'default_font_size' => 12,
            'default_font' => 'DejaVuSans'
        ]);

        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO} of {nbpg}');
        //$mpdf->AddPage('','','','','off','','','','','','','','','','','','','','','','A5');
        $mpdf->AddPageByArray(
            array(
                'orientation' => 'L',
                'suppress' => 'off',
                'sheet-size' => 'A4',
                'margin-left' => '7.62',
                'margin-top' => '7.62',
                'margin-bottom' => '7.62',
                'margin-right' => '7.62'
            )
        );

        //$data['organization'] = OrganizationSetting::find(1)->load('organizationLogo');

        $content = view('reports.collectiondetailed')->with($data);
        // $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }

    public function clientSubsidiaryLedger(Request $request)
    {
        $data['company_setting'] = CompanySetting::find(1);
        $contractId = $request->contract_id;
        $filters = $request->except('contract_id');
        $data['as_of_date'] = $filters['as_of_date'];

        $contractService = new ContractService();
        $data['contract'] = Contract::with('client')
            ->find($contractId);
        $data['data'] = $contractService->getContractHistory($contractId, $filters);

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

        $content = view('reports.clientsubsidiaryledger')->with($data);
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }

    public function accountsReceivableReport(Request $request)
    {
        $data['company_setting'] = CompanySetting::find(1);
        $filters = $request->all();
        $data['as_of_date'] = $filters['as_of_date'];

        $clients = Client::get();
        $clientService = new ClientService();
        foreach ($clients as $client) {
            $client->as_of_balance = $clientService->asOfBalance($client['id'], $filters);
        }
        $clients->append('as_of_balance');
        $data['clients'] = $clients;

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

        $content = view('reports.accountsreceivablereport')->with($data);
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }

    public function financialPosition(Request $request)
    {
        $data['company_setting'] = CompanySetting::find(1);
        $filters = $request->all();
        $data['as_of_date'] = $filters['as_of_date'];

        $data['accountTypes'] = AccountType::whereHas('accountClasses', function ($q) use ($data) {
            return $q->whereHas('accountTitles', function ($q) use ($data) {
                return $q->whereHas('journalEntries', function ($q) use ($data) {
                    return $q->where('transaction_date', '<=', $data['as_of_date'])
                    ->whereRaw('debit - credit != 0');
                });
            });
        })
        ->with(['accountClasses' => function ($q) use ($data) {
            return $q->with(['accountTitles' => function ($q) {
                return $q->with(['journalEntries'])
                ->whereHas('journalEntries');
            }])
                ->whereHas('accountTitles', function ($q) use ($data) {
                    return $q->whereHas('journalEntries', function ($q) use ($data) {
                        return $q->where('transaction_date', '<=', $data['as_of_date'])
                        ->whereRaw('debit - credit != 0');
                    });
                });
        }])
        ->find([1, 2, 3]);

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
        // return $data;
        $content = view('reports.financialposition')->with($data);
        $mpdf->WriteHTML($content);
        // return $mpdf->Output('');
        return $mpdf->Output('', 'S');
    }

    public function incomeStatement(Request $request)
    {
        $data['company_setting'] = CompanySetting::find(1);
        $data['system_setting'] = SystemSetting::find(1);
        $filters = $request->all();
        $data['date_from'] = $filters['date_from'];
        $data['date_to'] = $filters['date_to'];

        $data['accountTypes'] = AccountType::whereHas('accountClasses', function ($q) use ($data) {
            return $q->whereHas('accountTitles', function ($q) use ($data) {
                return $q->whereHas('journalEntries', function ($q) use ($data) {
                    return $q->whereBetween('transaction_date', [$data['date_from'], $data['date_to']])
                    ->whereRaw('debit - credit != 0');
                });
            });
        })
        ->with(['accountClasses' => function ($q) use ($data) {
            return $q->with(['accountTitles' => function ($q) {
                return $q->with(['journalEntries'])
                ->whereHas('journalEntries');
            }])
                ->whereHas('accountTitles', function ($q) use ($data) {
                    return $q->whereHas('journalEntries', function ($q) use ($data) {
                        return $q->whereBetween('transaction_date', [$data['date_from'], $data['date_to']])
                        ->whereRaw('debit - credit != 0');
                    });
                });
        }])
        ->find([4,5]);
        // return $data['accountTypes'];
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
        // return $data;
        $content = view('reports.incomestatement')->with($data);
        $mpdf->WriteHTML($content);
        // return $mpdf->Output('');
        return $mpdf->Output('', 'S');
    }
}

