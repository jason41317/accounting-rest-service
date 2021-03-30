<?php

namespace App\Models;

use App\Models\BaseModel;

class Ewallet extends BaseModel
{
  protected $guarded = ['id'];
  protected $hidden = [
    'created_at',
    'deleted_at',
    'updated_at',
    'created_by',
    'updated_by',
    'deleted_by'
  ];

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }
}
