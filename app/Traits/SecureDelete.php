<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;

trait SecureDelete
{
  /**
   * Delete only when there is no reference to other models.
   *
   * @param array $relations
   * @return response
   */
  public function secureDelete(String ...$relations)
  {
    $hasRelation = false;
    foreach ($relations as $relation) {
      if ($this->$relation()->withTrashed()->count()) {
        $hasRelation = true;
        break;
      }
    }

    if ($hasRelation) {
      throw ValidationException::withMessages([
        'msg' => ['Unable to delete this data. It is being used in other records.']
      ]);
    } else {
      $this->delete();
    }
  }
}