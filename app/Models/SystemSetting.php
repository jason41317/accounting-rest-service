<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends BaseModel
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

  // for audit
  public $isAuditable = true;
  public function auditing()
  {
    $auditing = [];
    $auditing['alias'] = 'System Setting';
    $auditing['key'] = '';
    return $auditing;
  }
    // end for audit
}
