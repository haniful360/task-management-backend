<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{


    protected $fillable = ['name', 'description', 'status', 'due_date', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
