<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Audit extends BaseModel
{
    protected $guarded = ['id'];
    protected $appends = ['message'];
    protected $hidden = [
        'auditable_type',
        'old_values',
        'new_values',
    ];
    
    public function auditable()
    {
        return $this->morphTo()
            ->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)
            ->with(['userable' => function ($q) {
                return $q->withTrashed();
            }]);
    }

    public function getMessageAttribute()
    {
        $msg = '';
        $desc = '';
        $user = $this->user_id !== Auth::id() ? $this->user->userable->name : 'You';

        switch ($this->event) {
            case 'Create':
                $desc = ' created a new ';
                break;
            case 'Update':
                $desc = ' updated ';
                break;
            case 'Delete':
                $desc = ' deleted ';
                break;
            case 'Approve':
                $desc = ' approved ';
                break;
            case 'Post':
                $desc = ' posted ';
                break;
            case 'Print':
                $desc = ' printed ';
                break;
            case 'Cancel':
                $desc = ' cancelled ';
                break;
            case 'Login':
                $desc = ' log in '. date('F d, Y h:i a', strtotime($this->created_at));
                break;
            case 'Logout':
                $desc = ' log out ' . date('F d, Y h:i a', strtotime($this->created_at));
                break;
        }
        $msg = $user . $desc . ($this->alias ?? '') . ($this->key ? ' - ' . $this->key : '');
        return $msg;
    }
}
