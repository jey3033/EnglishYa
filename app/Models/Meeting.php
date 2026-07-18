<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Meeting extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'date',
        'time',
        'lesson_plan',
        'term',
        'parent_id',
        'student_id',
        'teacher_id',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'time' => 'datetime:H:i',
        ];
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'meeting_student');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
