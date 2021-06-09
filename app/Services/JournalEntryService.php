<?php

namespace App\Services;

use App\Models\JournalEntry;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JournalEntryService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $journalEntries = $isPaginated
        ? JournalEntry::paginate($perPage)
        : JournalEntry::all();
      $journalEntries->load('accountTitles');
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
      $journalEntry->load('accountTitles');
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
}
