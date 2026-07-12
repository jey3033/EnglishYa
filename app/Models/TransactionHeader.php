<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHeader extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionHeaderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'invoice',
        'date',
        'total',
        'student_id',
        'detail',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'total' => 'float',
        ];
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'header_id');
    }
}
