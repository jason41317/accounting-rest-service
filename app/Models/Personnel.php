<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $appends = ['name'];
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function getNameAttribute()
    {
        return ucFirst($this->first_name) . ' ' . ucFirst($this->middle_name) . ' ' . ucFirst($this->last_name);
    }
}
