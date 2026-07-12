<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_header_id',
        'report_id',
        'course_id',
        'term_id',
        'price_per_hour',
        'hours',
        'subtotal',
        'detail',
    ];

    protected function casts(): array
    {
        return [
            'price_per_hour' => 'float',
            'hours' => 'integer',
            'subtotal' => 'float',
        ];
    }

    public function transactionHeader(): BelongsTo
    {
        return $this->belongsTo(TransactionHeader::class, 'header_id');
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
