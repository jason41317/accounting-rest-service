<?php

namespace App\Models;


class DocumentType extends BaseModel
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
        $auditing['alias'] = 'Document Type';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit
}
