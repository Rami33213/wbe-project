<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAction extends Model
{
    protected $fillable = [
        'admin_id',
        'action_type',
        'target_id',
        'target_type',
        'reason',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function target()
{
    return $this->morphTo();
}

}
