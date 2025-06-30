<?php

namespace App\Services;

use App\Models\JournalEntry;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JournalEntryService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = JournalEntry::with(['accountTitles','client']);

      //journal entry type
      $journalEntryTypeId = $filters['journal_entry_type_id'] ?? false;
      $query->when($journalEntryTypeId, function ($q) use ($journalEntryTypeId) {
        return $q->where('journal_entry_type_id', $journalEntryTypeId);
      });

      $sortKey = $filters['sort_key'] ?? 'id';
      $sortDesc = $filters['sort_desc'] ?? 'DESC';
      $query->orderBy($sortKey, $sortDesc);

      $journalEntries = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $journalEntries;
    } catch (Exception $e) {
      Log::info('Error occured during JournalEntryService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $accountTitles)
  {
    DB::beginTransaction();
    try {
      $journalEntry = JournalEntry::create($data);
      if ($accountTitles) {
        $items = [];
        foreach ($accountTitles as $accountTitle) {
          $items[$accountTitle['account_title_id']] = [
            'debit' => $accountTitle['debit'],
            'credit' => $accountTitle['credit']
          ];
        }
        $journalEntry->accountTitles()->sync($items);
      }
      $journalEntry->load('accountTitles');
      DB::commit();
      return $journalEntry;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during JournalEntryService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $journalEntry = JournalEntry::find($id);
      $journalEntry->load('accountTitles','client');
      return $journalEntry;
    } catch (Exception $e) {
      Log::info('Error occured during JournalEntryService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $accountTitles, int $id)
  {
    DB::beginTransaction();
    try {
      $journalEntry = JournalEntry::find($id);
      $journalEntry->update($data);
      if ($accountTitles) {
        $items = [];
        foreach ($accountTitles as $accountTitle) {
          $items[$accountTitle['account_title_id']] = [
            'debit' => $accountTitle['debit'],
            'credit' => $accountTitle['credit']
          ];
        }
        $journalEntry->accountTitles()->sync($items);
      }
      $journalEntry->load('accountTitles');
      DB::commit();
      return $journalEntry;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during JournalEntryService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $journalEntry = JournalEntry::find($id);
      $journalEntry->secureDelete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during JournalEntryService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function generalJournalNo()
  {
    $now = Carbon::now();
    $count = JournalEntry::where('journal_entry_type_id', 4)
      ->count() + 1;

    return 'GJ-' . date('Ym', strtotime($now->year . '-' . $now->month . '-1')) . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
  }
}
