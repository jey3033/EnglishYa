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
        return $this->belongsTo(TransactionHeader::class);
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
