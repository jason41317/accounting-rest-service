<?php

namespace App\Traits;

use App\Models\Audit;

trait IsAuditable
{
  public function audits()
  {
    return $this->morphMany(Audit::class, 'auditable');
  }
}