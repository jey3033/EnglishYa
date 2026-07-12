<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentData extends Model
{
    /** @use HasFactory<\Database\Factories\StudentDataFactory> */
    use HasFactory;

    protected $fillable=[
        'student_id',
        'profile_path',
        'preferred_language',
        'notes'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
