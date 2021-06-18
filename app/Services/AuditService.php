<?php

namespace App\Services;

use App\Models\Audit;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  { 
    try {
      $query = Audit::with(['auditable', 'user' => function ($q) {
        return $q->with('userable', function($q) {
          return $q->with('photo');
        });
      }]);

      $auditableType = $filters['auditable_type'] ?? null;
      $auditableId = $filters['auditable_id'] ?? null;
      $event = $filters['event'] ?? null;
      $userId = $filters['user_id'] ?? null;
      $orderBy = $filters['order_by'] ?? null;
      $sort = $filters['sort'] ?? false;
      $id = $filters['id'] ?? false;

      $query->when($auditableType, function($q) use ($auditableType) {
        return $q->where('auditable_type', $auditableType);
      });

      $query->when($auditableId, function ($q) use ($auditableId) {
        return $q->where('auditable_id', $auditableId);
      });

      $query->when($event, function ($q) use ($event) {
        return $q->where('event', $event);
      });

      $query->when($userId, function ($q) use ($userId) {
        return $q->where('user_id', $userId);
      });

      $query->when($id, function ($q) use ($id) {
        return $q->where('id', '>', $id);
      });

      $query->when($orderBy, function ($q) use ($orderBy, $sort) {
        return $q->orderBy($orderBy, $sort ?? 'DESC');    
      });

      $audits = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $audits;
    } catch (Exception $e) {
      Log::info('Error occured during AuditService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $audit = Audit::create($data);
      DB::commit();
      return $audit;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AuditService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}