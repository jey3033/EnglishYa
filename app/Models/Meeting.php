<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Meeting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'date',
        'start',
        'end',
        'lesson_plan',
        'teacher_id',
        'transaction_detail_id',
        'status'
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
        return $this->belongsToMany(User::class, 'meeting_student', 'meeting_id', 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
