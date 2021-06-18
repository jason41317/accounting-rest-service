<?php

namespace App\Models;

use App\Traits\IsAuditable;
use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes, SecureDelete, IsAuditable;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = Auth::id();
            }
        });

        static::created(function ($model) {
            if ($model->isAuditable) {
                $auditing = $model->auditing();
                $model->audits()->create([
                    'user_id' => Auth::id(),
                    'event' => 'Create',
                    'new_values' => $model,
                    'alias' => $auditing['alias'],
                    'key' => $auditing['key']
                ]);
            }
        });

        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = Auth::id();
            }
        });

        static::updated(function ($model) {
            if ($model->isAuditable && !isset($model->deleted_at)) {
                $auditing = $model->auditing();
                $event = 'Update';

                if (isset($auditing['status_key']) && count($auditing['statuses']->where('id', $model[$auditing['status_key']]))) {
                    $event = $auditing['statuses']->where('id', $model[$auditing['status_key']])->first()['event'];  
                }

                $model->audits()->create([
                    'user_id' => Auth::id(),
                    'event' => $event,
                    'old_values' => json_encode($model->getOriginal()),
                    'new_values' => $model,
                    'alias' => $auditing['alias'],
                    'key' => $auditing['key']
                ]);
            }
        });

        static::deleted(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                $model->deleted_by = Auth::id();
                $model->save();
            }
            if ($model->isAuditable) {
                $auditing = $model->auditing();
                $model->audits()->create([
                    'user_id' => Auth::id(),
                    'event' => 'Delete',
                    'old_values' => json_encode($model->getOriginal()),
                    'alias' => $auditing['alias'],
                    'key' => $auditing['key']
                ]);
            }
        });
    }
}
