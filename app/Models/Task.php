<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'due_date',
        'user_id',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activities() {
        return $this->hasMany(TaskActivity::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            $task->slug = Str::slug($task->name) . '-' . uniqid(); // Ensure unique slug
        });

        static::updating(function ($task) {
            if ($task->isDirty('name')) {
                $task->slug = Str::slug($task->name) . '-' . uniqid();
            }
        });
    }
}
