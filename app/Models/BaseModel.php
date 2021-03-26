<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class BaseModel extends Model implements Auditable
{
    use HasFactory, SoftDeletes, SecureDelete, \OwenIt\Auditing\Auditable;
}
