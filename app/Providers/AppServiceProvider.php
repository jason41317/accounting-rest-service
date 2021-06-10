<?php

namespace App\Providers;

use App\Models\Billing;
use App\Models\BillingPeriod;
use App\Models\ClosedBillingPeriod;
use App\Models\Payment;
use App\Models\Contract;
use App\Models\ContractAssignee;
use App\Models\Disbursement;
use App\Observers\BillingObserver;
use App\Observers\BillingPeriodObserver;
use App\Observers\ContractAssigneeObserver;
use App\Observers\PaymentObserver;
use Illuminate\Support\Facades\DB;
use App\Observers\ContractObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Observers\DisbursementObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        JsonResource::withoutWrapping();

        if (Config::get('database.log')) {
            DB::listen(function ($query) {
                Log::info(
                    $query->sql,
                    $query->bindings,
                    $query->time
                );
            });
        }

        Disbursement::observe(DisbursementObserver::class);
        Contract::observe(ContractObserver::class);
        Payment::observe(PaymentObserver::class);
        ContractAssignee::observe(ContractAssigneeObserver::class);
        BillingPeriod::observe(BillingPeriodObserver::class);
        // Billing::observe(BillingObserver::class);
    }
}
