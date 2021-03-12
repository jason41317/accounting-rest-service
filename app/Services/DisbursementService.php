<?php

namespace App\Services;

use App\Models\Disbursement;
use App\Models\DisbursementStatus;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DisbursementService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
        
        $query = Disbursement::with(['bank', 'disbursementStatus', 'disbursementDetails']);

        //filter disbursement status id
        $disbursementStatusId = $filters['disbursement_status_id'] ?? false;
        $query->when($disbursementStatusId, function($q) use($disbursementStatusId) {
            return $q->where('disbursement_status_id', $disbursementStatusId);
        });


        $disbursements = $isPaginated
            ? $query->paginate($perPage)
            : $query->get();

      return $disbursements;
    } catch (Exception $e) {
      Log::info('Error occured during DisbursementService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $disbursementDetails)
  {
    DB::beginTransaction();
    try {
      $disbursement = Disbursement::create($data);
      
      if ($disbursementDetails) {
        foreach ($disbursementDetails as $detail) {
          $disbursement->disbursementDetails()->create(
            [
              'particular' => $detail['particular'],
              'amount' => $detail['amount'],
              'account_title_id' => $detail['account_title_id']
            ]
          );
        }
      }

      DB::commit();
      return $disbursement;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during DisbursementService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $disbursement = Disbursement::find($id);
      $disbursement->load(['disbursementDetails', 'disbursementStatus', 'bank', 'approvedByPersonnel']);
      return $disbursement;
    } catch (Exception $e) {
      Log::info('Error occured during DisbursementService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $disbursementDetails, int $id)
  {
    DB::beginTransaction();
    try {
      $disbursement = Disbursement::find($id);
      $disbursement->update($data);

      

      if ($disbursementDetails) {
        $disbursement->disbursementDetails()->delete();
        foreach ($disbursementDetails as $detail) {
          $disbursement->disbursementDetails()->create(
            [
              'particular' => $detail['particular'],
              'amount' => $detail['amount'],
              'account_title_id' => $detail['account_title_id']
            ]
          );
        }
      }

      DB::commit();
      return $disbursement;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during DisbursementService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $disbursement = Disbursement::find($id);
      $disbursement->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during DisbursementService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
