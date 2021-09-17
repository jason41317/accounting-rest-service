<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\Client;
use App\Models\CompanySetting;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ClientService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = Client::with(['contracts']);

      $criteria = $filters['criteria'] ?? false;
      $query->when($criteria, function ($q) use ($criteria) {
        // return $q->whereHas('student', function ($query) use ($criteria) {
        return $q->where('name', 'like', '%' . $criteria . '%')
          ->orWhere('name', 'like', '%' . $criteria . '%')
          ->orWhere('office_address', 'like', '%' . $criteria . '%')
          ->orWhere('owner', 'like', '%' . $criteria . '%')
          ->orWhere('email', 'like', '%' . $criteria . '%')
          ->orWhere('contact_no', 'like', '%' . $criteria . '%')
          ->orWhereHas('businessStyle', function ($q) use ($criteria) {
            return $q->where('name', 'like', '%' . $criteria . '%');
          })
          ->orWhereHas('businessType', function ($q) use ($criteria) {
            return $q->where('name', 'like', '%' . $criteria . '%');
          });
      });


      $clients = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $clients;
    } catch (Exception $e) {
      Log::info('Error occured during ClientService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $client = Client::create($data);
      $client->user()->create([
        'username' => $client->email,
        'password' => Hash::make('password')
      ]);
      // $client->load(['businessStyle', 'businessType']);
      DB::commit();
      return $client;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $client = Client::find($id);
      // $client->load(['businessStyle', 'businessType']);
      return $client;
    } catch (Exception $e) {
      Log::info('Error occured during ClientService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $client = Client::find($id);
      $client->update($data);
      // $client->load(['businessStyle', 'businessType']);
      DB::commit();
      return $client;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $client = Client::find($id);
      $client->secureDelete('contracts', 'billings', 'payments');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function asOfBalance($clientId, $filters)
  {
    $company = CompanySetting::find(1);
    $filterDate = $filters['as_of_date'] ?? Carbon::now();
    $year = $filters['year'] ?? null;
    $monthId = $filters['month_id'] ?? null;
    if ($year && $monthId) {
      $filterDate = new Carbon($year . '-' . $monthId . '-' . $company->billing_cutoff_day);
    }

    $billings = Billing::where('client_id', $clientId)
      ->whereRaw('DATE(CONCAT(year,"-",month_id,"-",1)) <= DATE("' . $filterDate . '")')
      ->get()
      ->sum('amount');
    $payments = Payment::where('client_id', $clientId)
      ->where('payment_status_id', 2)
      ->whereRaw('DATE(transaction_date) <= DATE("' . $filterDate . '")')
      ->get()
      ->sum('amount');
    return $billings - $payments;
  }

  public function changePassword(array $data, int $clientId)
  {
    DB::beginTransaction();
    try {
      $client = Client::find($clientId);
      $client->user()->update([
        'password' => Hash::make($data['password'])
      ]);
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService changePassword method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
