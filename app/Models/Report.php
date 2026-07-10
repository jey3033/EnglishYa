<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'meeting_number',
        'meeting_date',
        'meeting_report',
        'term',
        'time_start',
        'time_end',
        'parent_id',
        'student_id',
        'teacher_id',
    ];

    protected function casts(): array
    {
        return [
            'meeting_date' => 'date',
            'time_start' => 'datetime:H:i',
            'time_end' => 'datetime:H:i',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
